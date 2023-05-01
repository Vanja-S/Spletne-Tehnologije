"""An example of a simple HTTP server."""
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
WWW_DATA = "./www-data"


# Header template for a successful HTTP request
HEADER_RESPONSE_200 = """HTTP/1.1 200 OK\r
content-type: %s\r
content-length: %d\r
connection: Close\r
\r
"""

# Response templates
RESPONSE_301 = """HTTP/1.1 301 Moved Permanently\r
location: %s\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>301 Moved permanently</h1>
<p>Page was moved permanently.</p>
"""

RESPONSE_400 = """HTTP/1.1 400 Bad request\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>400 Bad request</h1>
<p>Request doesn't seem to match server's requirements.</p>
"""

RESPONSE_404 = """HTTP/1.1 404 Not found\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>404 Page not found</h1>
<p>Page cannot be found.</p>
"""

RESPONSE_405 = """HTTP/1.1 405 Method not allowed\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>not allowed</h1>
"""

RESPONSE_505 = """HTTP/1.1 505 HTTP Version Not Supported\r
connection: Close\r
"""

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

def guess_type(file):
    type, encoding = mimetypes.guess_type(file)
    if type == None:
        return "application/octet-stream"
    return type

def get_params(uri):
    if len(uri.split("?")) == 1:
        return uri, None

    path = unquote_plus(uri.split("?")[0])
    params = unquote_plus(uri.split("?")[1])
    return path, params

def parse_params(params):
    criteria = {}
    if not params == None:
        param = params.split("&")
        if len(param) == 1:
            key, value = param[0].split("=")
            criteria[key] = value
        else:
            for param in params.split("&"):
                key, value = param.split("=")
                criteria[key] = value
    return criteria

# def send_headers(connection, header_template, )

def process_request(connection, address):
    """Process an incoming socket request.

    :param connection is a socket of the client
    :param address is a 2-tuple (address(str), port(int)) of the client
    """
    request = connection.recv(1024).decode("utf-8")

    headers = request.split("\n")

    if not len(headers[0].split()) == 3:
        connection.send(bytes(RESPONSE_400, "utf-8"))
        return

    method, uri, version = headers[0].split()

    if not version == "HTTP/1.1":
        connection.send(bytes(RESPONSE_505, "utf-8"))
        return

    # Poglej, če so parametri v requestu, če so jih shrani, če ne je path == uri in params == None
    path, params = get_params(uri)

    if path == "/app-add":
        if method != "POST":
            connection.send(bytes(RESPONSE_405, "utf-8"))
            return

        # Pridobi podatke iz body-ja
        body = request.split("\n")[-1]
        str = unquote_plus(body)
        first, last = str.split("&")[0].split("=")[1], str.split("&")[1].split("=")[1]

        if len(first) == 0 or len(last) == 0:
            connection.send(bytes(RESPONSE_400, "utf-8"))
            return

        # Shrani v bazo
        save_to_db(first, last)

        # Pošlji app_add.html
        file = WWW_DATA + "/app_add.html"
        with open(file, "rb") as handle:
            content = handle.read()

        type = guess_type(file)

        header = HEADER_RESPONSE_200 % (
            type,
            len(content)
        )
        connection.send(join(bytes(header, "utf-8"), content))

    elif path == "/app-index":
        if method != "GET":
            connection.send(bytes(RESPONSE_405, "utf-8"))
            return

        criteria = parse_params(params)
        result = read_from_db(criteria)

        students = ""
        for student in result:
            number = student["number"]
            first = student["first"]
            last = student["last"]
            students += TABLE_ROW % (
                int(number),
                first,
                last
            )

        students = students.strip()

        file = WWW_DATA + "/app_list.html"
        with open(file, "rb") as handle:
            content = handle.read()

        content = content.replace(b"{{students}}", bytes(students, "utf-8"))

        type = guess_type(file)
        header = HEADER_RESPONSE_200 % (
            type,
            len(content)
        )

        connection.send(join(bytes(header, "utf-8"), content))

    elif path == "/app-json":
        if method != "GET":
            connection.send(bytes(RESPONSE_405, "utf-8"))
            return

        criteria = parse_params(params)
        result = json.dumps(read_from_db(criteria))
        header = HEADER_RESPONSE_200 % (
            "application/json",
            len(result)
        )
        connection.send(join(bytes(header, "utf-8"), bytes(result, "utf-8")))

    else:
        if not method == "GET":
            connection.send(bytes(RESPONSE_405, "utf-8"))
            return
        fullPath = WWW_DATA + path
        if path[-1] == "/":
            if "index.html" in listdir(fullPath):
                file = fullPath + "index.html"
                with open(file, "rb") as handle:
                    content = handle.read()
                type = guess_type(file)
                header = HEADER_RESPONSE_200 % (
                    type,
                    len(content)
                )
                connection.send(join(bytes(header, "utf-8"), content))
            else:
                contents = FILE_TEMPLATE % (
                    "..",
                    ".."
                )
                files = sorted(listdir(fullPath))
                for file in files:
                    contents += FILE_TEMPLATE % (
                        file,
                        file
                    )
                content = DIRECTORY_LISTING % (
                    path,
                    path
                )
                content = content.replace("{{CONTENTS}}", contents)
                header = HEADER_RESPONSE_200 % (
                    "text/html",
                    len(listdir(fullPath))
                )
                connection.send(join(bytes(header, "utf-8"), bytes(content, "utf-8")))
        else:
            if isdir(fullPath):
                header = RESPONSE_301 % (
                        path + "/"
                )
                connection.send(bytes(header, "utf-8"))
            elif isfile(fullPath):
                with open(fullPath, "rb") as handle:
                    content = handle.read()

                type = guess_type(fullPath)
                header = HEADER_RESPONSE_200 % (
                    type,
                    len(content)
                )
                connection.send(join(bytes(header, "utf-8"), content))
            else:
                connection.send(bytes(RESPONSE_404, "utf-8"))

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