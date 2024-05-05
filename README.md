<div align="center">
  <img src="./Blood_Bank/images/favicon.png" alt="logo" width="80" height="80">
  <h2>Blood-Bank-Management-System</h2>
  <h3>|| <ins>Setup Guide</ins> ||</h3>
</div>

### Prerequisites:
- Ubuntu Instance
- Install <ins>**Docker**</ins>, <ins>**Docker-Compose**</ins> & <ins>**Git**</ins>

### <ins>Step 1:</ins> Install Docker
```
sudo apt update
sudo apt install -y docker.io
sudo usermod -aG docker ubuntu
newgrp docker
docker --version
```

### <ins>Step: 2</ins> Install Docker-Compose
```
sudo curl -L "https://github.com/docker/compose/releases/download/v2.27.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
docker-compose --version
```

### <ins>Step: 3</ins> Check the version of git.
```
git --version | cut -d ' ' -f3
```

### <ins>Step 4:</ins> Clone this repository.
```
git clone https://github.com/soravkumarsharma/Blood-Bank-Management-System.git
```

### <ins>Step 5:</ins> Change the directory.
```
cd Blood-Bank-Management-System
```

### <ins>Step 6:</ins> Create environment variable file.
```
mv .env.example .env
```
### <ins>Step 7:</ins> Start docker containers in detached mode.
```
docker-compose up -d
```

### <ins>Step 8:</ins> Check the containers are up and running.
```
docker ps
```

### <ins>Step 9:</ins> Access Application.
### Go to your browser, and access this <ins>**Blood Bank Application**</ins> on port <ins>**80**</ins> and <ins>**phpmyadmin**</ins> dashboard on port <ins>**8080**</ins> via the ubuntu instance public IPv4 or IPv6.

#### ***Make sure that the inbound ports 80, 8080 should be opened in the security group.***

## Credentials for Admin dashboard.
- <ins>username</ins> : **admin**
- <ins>password</ins> : **admin**




