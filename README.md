<div align="center">
  <img src="./Blood_Bank/images/favicon.png" alt="logo" width="80" height="80">
  <h2>Blood-Bank-Management-System</h2>
  <h3>|| <ins>Setup Guide</ins> ||</h3>
</div>

### Prerequisites:
- Install <ins>**Docker**</ins> & <ins>**Git**</ins>

### <ins>Step 1:</ins> Clone this repository.
```
git clone https://github.com/soravkumarsharma/Blood-Bank-Management-System.git
```

### <ins>Step 2:</ins> Change the directory.
```
cd Blood-Bank-Management-System
```

### <ins>Step 3:</ins> Create environment variable file.
```
mv .env.example .env
```
### <ins>Step 4:</ins> Start docker containers in detached mode.
```
docker-compose up -d
```

### <ins>Step 5:</ins> Check the containers are up and running.
```
docker ps
```

### <ins>Step 6:</ins> Access Application.
### Go to your browser, and access this application using [localhost](http://localhost:80) and access phpmyadmin using [localhost:8080](http://localhost:8080)




