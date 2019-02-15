# Great task for Great Fullstack Developer

## Requirements
- Create github OAuth App, callback url must be: https://127.0.0.1/login/check-github
- docker
- docker-compose
- Open port: ```443```

## Run development environment
```sh
$ git clone https://github.com/psanonym/fullstack-party
```
```sh
$ cd fullstack-party
```
```sh
$ ./run-app.sh
```
in the ```.env``` file set ```GITHUB_CLIENT_ID``` and ```GITHUB_CLIENT_SECRET``` values
Open in the browser: https://127.0.0.1


## Api endpoints
```
/api/issues/{username}/{repositoryName}/{pageId}
```
```
/api/issue/{username}/{repositoryName}/{issueId}
```

## Known issues
- Not implemented exception handling
- Certificate is not trusted, because it's generate Self-Signed, not by a CA
