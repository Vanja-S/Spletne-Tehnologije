from urllib.request import urlopen
import requests


def get(url, port, resource):
    return urlopen("http://%s:%d%s" % (url, port, resource)).read()


if __name__ == "__main__":
    print(get("localhost", 8080, "/fri_logo.png"))
