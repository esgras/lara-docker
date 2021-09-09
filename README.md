## Setting up DEV environment
1.Clone this repository from GitHub.

2.Add domain to local 'hosts' file:
```bash
127.0.0.1    localhost
```
3.Build, start and install the docker images from your terminal:
```bash
make build
make start
make composer-install
make create-mysql-db
migrate-all
```

4.Check all success after running tests..
```bash
phpunit-test
```
