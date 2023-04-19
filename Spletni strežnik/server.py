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


DIRECTORY_LISTING = """<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Directory listing: %s</title>

<h1>Contents of %s:</h1>

<ul>
{{CONTENTS}}
</ul> 
"""

FILE_TEMPLATE = "  <li><a href='%s'>%s</li>"

# Class for storing http response headers
class HttpResponses:
    # Template for a 404 (Not found) error
    RESPONSE_404 = """HTTP/1.1 404 Not found\r
    Content-Type: text/html; charset=utf-8\r
    Content-Length: 80
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
    
    # Header for Method Not Allowed 405
    RESPONSE_405 = """HTTP/1.1 405 Method Not Allowed\r
    Content-Type: text/html; charset=utf-8\r
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
    Content-Type: text/html; charset=utf-8\r
    Content-Length: \r
    Connection: keep-alive\r
    Location: %s\r
\r
<!doctype html>
<html>
    <body>
        <h1>301 Moved Permanently</h1>
        <a href="%s">%s</p>
    </body>
</html> 
    """


# Class for storing info about a url once it's parsed
class ParseResult:
    def __init__(self, scheme, userinfo, host, port, path, query, fragment):
        self.scheme = scheme
        self.userinfo = userinfo
        self.host = host
        self.port = port
        self.path = path
        self.query = query
        self.fragment = fragment
    
    def geturl(self):
        netloc = self.host
        if self.userinfo:
            netloc = f"{self.userinfo}@{netloc}"
        if self.port:
            netloc = f"{netloc}:{self.port}"
        return f"{self.scheme}://{netloc}{self.path}{self.query}{self.fragment}"



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
    url_object = url_parse(unquote_plus(request[1]))
    # Read and parse headers
    parse_headers(client)
    # Read and parse the body of the request (if applicable)
    body = parse_body()
    # create the response
    response = create_response(request[0], url_object.path, body)

    # Write the response back to the socket
    client.write(response)
    client.close()

def url_parse(url):
    parts = url.split('://')
    if len(parts) > 1:
        scheme, rest = parts
    else:
        scheme, rest = '', parts[0]
    parts = rest.split('/', 1)
    if len(parts) > 1:
        netloc, path = parts
        if '/' in path:
            path, query = path.split('?', 1)
        else:
            query = ''
    else:
        netloc, path, query = parts[0], '', ''
    if '@' in netloc:
        userinfo, netloc = netloc.split('@', 1)
    else:
        userinfo = ''
    if ':' in netloc:
        host, port = netloc.split(':', 1)
    else:
        host, port = netloc, ''
    return ParseResult(scheme, userinfo, host, port, path, query, '')


def create_GET_response(uri_path):
    try:
        with open(uri_path):
            pass
    except FileNotFoundError:
        return HttpResponses.RESPONSE_404.encode("utf-8")

def create_response(method: str, uri_path, body = None):
    if method == "GET":
        return create_GET_response(uri_path)
    else:
        return


SUPPORTED_METHODS = {
    "GET",
    "POST"
}


def parse_request_line(client):
    request_line = client.readline().decode("utf-8").strip()

    if(not SUPPORTED_METHODS.__contains__(request_line.split()[0])):
        client.write(HttpResponses.RESPONSE_405.encode("utf-8"))
        client.close()
        return
        
    return (request_line.split()[0], request_line.split()[1])


def parse_headers():

    return


def parse_body():
    return None


def main(port):
    """Starts the server and waits for connections."""

    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server.bind(("", port))
    server.listen(1)

    print("Listening on %d" % port)

    while True:
        connection, address = server.accept()
        print("[%s:%d] CONNECTED" % address)
        process_request(connection, address)
        connection.close()
        print("[%s:%d] DISCONNECTED" % address)


if __name__ == "__main__":
    main(8080)
