import json
import mimetypes
import pickle
import socket
from os import listdir
from os.path import isdir, isfile, join
from urllib.parse import unquote_plus

# Pickle file for storing data
PICKLE_DB = "db.pkl"

# Directory containing www data
WWW_DATA = "www-data"


# Represents a table row that holds user data
TABLE_ROW = """
<tr>
    <td>%d</td>
    <td>%s</td>
    <td>%s</td>
</tr>
"""


DIRECTORY_LISTING = """<!doctype html>
<html lang="en">
<meta charset="UTF-8">
<title>Directory listing: %s</title>

<html>
    <body>
        <h1>Contents of %s:</h1>
        <ul>
            %s
        </ul>
    </body>
</html> 
"""

FILE_TEMPLATE = "<li><a href='%s'>%s</li>"

# Class for storing http response headers
class HttpResponses:
    # Template for a 404 (Not found) error
    RESPONSE_404 = """HTTP/1.1 404 Not found\r
Content-Type: text/html\r
Content-Length: 80\r
Connection: Close\r
\r
<!doctype html>
<h1>404 Page not found</h1>
<p>Page cannot be found.</p>"""
    
    # Header template for a successful HTTP request
    RESPONSE_200 = """HTTP/1.1 200 OK\r
Content-Type: %s\r
Content-Length: %d\r
Connection: Close\r
\r
"""

    # Header template for a successful HTTP request
    RESPONSE_200_EMPTY = """HTTP/1.1 200 OK\r
Connection: Close\r
\r
"""
    
    # Header for Method Not Allowed 405
    RESPONSE_405 = """HTTP/1.1 405 Method Not Allowed\r
Content-Type: text/html\r
Content-Length: 176\r
Connection: Close\r
\r
<!doctype html>
<html>
    <body>
        <h1>405 Method Not Allowed</h1>
        <p>The requested method could not be executed.</p>
    </body>
</html>"""

    RESPONSE_301 = """HTTP/1.1 301 Moved Permanently\r
Location: %s\r
\r
"""
    
    RESPONSE_400 = """HTTP/1.1 400 Bad Request\r
Content-Type: text/html\r
Content-Length: 86\r
Connection: Close\r
\r
<!doctype html>
<html>
    <body>
        <h1>400 Bad Request</h1>
    </body>
</html>"""


def save_to_db(first, last):
    """Create a new user with given first and last name and store it into
    file-based database.

    For instance, save_to_db("Mick", "Jagger"), will create a new user
    "Mick Jagger" and also assign him a unique number.

    Do not modify this method."""

    existing = read_from_db()
    existing.append({
        "number": 1 if len(existing) == 0 else existing[-1]["number"] + 1,
        "first": first,
        "last": last
    })
    with open(PICKLE_DB, "wb") as handle:
        pickle.dump(existing, handle)


def read_from_db(criteria=None):
    """Read entries from the file-based DB subject to provided criteria

    Use this method to get users from the DB. The criteria parameters should
    either be omitted (returns all users) or be a dict that represents a query
    filter. For instance:
    - read_from_db({"number": 1}) will return a list of users with number 1
    - read_from_db({"first": "bob"}) will return a list of users whose first
    name is "bob".

    Do not modify this method."""
    if criteria is None:
        criteria = {}
    else:
        # remove empty criteria values
        for key in ("number", "first", "last"):
            if key in criteria and criteria[key] == "":
                del criteria[key]

        # cast number to int
        if "number" in criteria:
            criteria["number"] = int(criteria["number"])

    try:
        with open(PICKLE_DB, "rb") as handle:
            data = pickle.load(handle)

        filtered = []
        for entry in data:
            predicate = True

            for key, val in criteria.items():
                if val != entry[key]:
                    predicate = False

            if predicate:
                filtered.append(entry)

        return filtered
    except (IOError, EOFError):
        return []


def process_request(connection, address):
    """Process an incoming socket request.

    :param connection is a socket of the client
    :param address is a 2-tuple (address(str), port(int)) of the client
    """
    client = connection.makefile("wrb") 

    # Read and parse the request line

    request = parse_request_line(client)

    if isinstance(request, bool):
        return

    if request == "" or request == None:
        response = HttpResponses.RESPONSE_200_EMPTY.encode("utf-8")
        client.write(response)
        client.close()
        return

    else:
        url_path = request[1]
    # Read and parse headers
    header_pass, parameters = parse_headers_and_body(client, True if request[0] == "GET" else False)
    if not header_pass:
        response = HttpResponses.RESPONSE_400.encode("utf-8")
    # Read and parse the body of the request (if applicable)
    # create the response
    else: 
        response = create_response(request[0], url_path, parameters)

    # Write the response back to the socket
    client.write(response)
    client.close()


def parse_parameters(url_path):
    if(url_path.find('?') == -1):
        return (url_path, {})
    url_path, param_string = url_path.split('?')
    return (url_path, parse_dict_params(param_string))
    
def parse_dict_params(param_string):
    parameters = {}
    
    # Extracting the parameters and putting them into the dictionary
    
    param_string = unquote_plus(param_string)
    param_string = param_string.split('&')

    for param in param_string:
        key, value = param.split('=')
        parameters[key] = value

    return parameters


def serve_app_index(parameters: dict, uri_path):
    result = read_from_db(parameters)

    students = ""
    for entry in result:
        students += TABLE_ROW % (int(entry["number"]), entry["first"], entry["last"])
    students = students.strip()

    with open(uri_path, "rb") as file:
        content = file.read()
    content = content.replace(b"{{students}}", bytes(students, "utf-8"))

    file_type, _ = mimetypes.guess_type(uri_path)

    return (bytes(HttpResponses.RESPONSE_200 % (file_type, len(content)), "utf-8") + content)


def serve_app_json(parameters: dict):
    response = json.dumps(read_from_db(parameters))
    return (HttpResponses.RESPONSE_200 % ("application/json", len(response)) + response).encode("utf-8")


def create_GET_response(uri_path, parameters):
        url_path = uri_path
        uri_path = __file__[:__file__.rindex('/') + 1] + WWW_DATA + "/" + uri_path

        # Dynamic content
        if url_path == "/app-index":
            uri_path = __file__[:__file__.rindex('/') + 1] + WWW_DATA + "/app_list.html" 
            return serve_app_index(parameters, uri_path)
        elif url_path == "/app-json":
            return serve_app_json(parameters)
        
        # Static content
        # If resource is file
        if isfile(uri_path):
            try:
                with open(uri_path):
                    pass
            except FileNotFoundError:
                return HttpResponses.RESPONSE_404.encode("utf-8")
            return serve_file(uri_path)
        # Else it's a dir
        else:
            try:
                listdir(uri_path)
            except FileNotFoundError:
                return HttpResponses.RESPONSE_404.encode("utf-8")
            if url_path[-1] == '/':
                return serve_dir(url_path, uri_path)
            else:
                return serve_dir_redirect(url_path)


def serve_dir(url_path, uri_path):
    contents = [FILE_TEMPLATE % ("..", "..")]
    index = ""
    for file in sorted(listdir(uri_path)):
        if file == "index.html":
            index = file
        contents.append(FILE_TEMPLATE % (file, file))
    if index != "":
        return serve_file(uri_path + index)
    else:
        contents = "\n".join(contents)
        body = DIRECTORY_LISTING % (url_path, url_path, contents)
        return (HttpResponses.RESPONSE_200 % ('text/html', len(body)) + body).encode("utf-8")


def serve_dir_redirect(url_path: str):
    location = "http://" + SERVER_IP + ":" + str(server_port) + url_path + '/'
    print(HttpResponses.RESPONSE_301 % (location))
    return (HttpResponses.RESPONSE_301 % (location)).encode("utf-8")


def serve_file(uri_path: str):
    file_type, _ = mimetypes.guess_type(uri_path)
    print(file_type)
    if file_type == None:
        file_type = 'application/octet-stream'
    with open(uri_path, 'rb') as file:
        content = file.read()
        response = (bytes(HttpResponses.RESPONSE_200 % (file_type, len(content)), 'utf-8') + content)
    return response
    

def create_POST_response(url_path, parameters: dict):
    if url_path == "/app-add":
        if not all(key in parameters for key in ["first", "last"]):
            return HttpResponses.RESPONSE_400.encode("utf-8")
        save_to_db(parameters["first"], parameters["last"])
        uri_path = __file__[:__file__.rindex('/') + 1] + WWW_DATA + "/" + "app_add.html"
        return serve_file(uri_path)
    else: 
        return HttpResponses.RESPONSE_405.encode("utf-8")


def create_response(method: str, url_path, parameters = None):
    if method == "GET":
        url_path, parameters = parse_parameters(url_path)
        return create_GET_response(url_path, parameters)
    else:
        return create_POST_response(url_path, parameters)


SUPPORTED_METHODS = {
    "GET",
    "POST"
}


UNSUPPORTED_METHODS = {
    "OPTIONS",
    "HEAD", 
    "PUT",
    "DELETE",
    "TRACE",
    "CONNECT",
    "PATCH"
}


def parse_request_line(client):
    request_line = client.readline().decode("utf-8").strip()

    if(len(request_line) == 0 or not SUPPORTED_METHODS.__contains__(request_line.split()[0])):
        if len(request_line) == 0:
            client.write(HttpResponses.RESPONSE_200_EMPTY.encode("utf-8"))
        elif UNSUPPORTED_METHODS.__contains__(request_line.split()[0]):
            client.write(HttpResponses.RESPONSE_405.encode("utf-8"))
        else:
            client.write(HttpResponses.RESPONSE_400.encode("utf-8"))
        client.close()
        return False
    print(request_line)
    return (request_line.split()[0], request_line.split()[1])


def parse_headers_and_body(client, get_request) -> tuple:
    host = False
    content_lenght = False
    parameters = {}
    while True:
        line = client.readline().decode("utf-8").strip()
        if line.startswith("Host:"):
            host = True
        elif line.startswith("Content-Length:"):
            lenght = int(line.split(":")[1].strip())
            content_lenght = True
        if line == "" and not get_request:
            parameters = parse_body(client, lenght, parameters)
            break
        elif line == "" and get_request:
            break
        print(line)
    
    if (content_lenght or get_request) and host:
        return (True, parameters)
    return (False, {})


def parse_body(client, lenght, parameters):
    read_len = 0
    params_string = ""
    while read_len != lenght:
        char = client.read(1).decode("utf-8").strip()
        read_len += 1
        params_string += char
    parameters |= parse_dict_params(params_string)
    return parameters

SERVER_IP = "localhost"
server_port = 8080

def main(port):
    global server_port 
    server_port = port
    """Starts the server and waits for connections."""

    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server.bind((SERVER_IP, port))
    server.listen(1)

    print("Listening on %d" % port)

    while True:
        connection, address = server.accept()
        print("[%s:%d] CONNECTED" % address)
        process_request(connection, address)
        connection.close()
        print("[%s:%d] DISCONNECTED" % address)


if __name__ == "__main__":
    main(server_port)
