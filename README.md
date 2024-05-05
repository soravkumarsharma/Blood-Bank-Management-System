<div align="center">
  <img src="./Blood_Bank/images/favicon.png" alt="logo" width="80" height="80">
  <h2>Blood-Bank-Management-System</h2>
  <h3>|| <ins>Setup Guide</ins> ||</h3>
</div>

### <ins>Prerequisites</ins>:
- Ubuntu Instance
- Install <ins>**Docker**</ins>, <ins>**Docker-Compose**</ins> & <ins>**Git**</ins>

### <mark>Step 1</mark> : Install Docker
```
sudo apt update
sudo apt install -y docker.io
sudo usermod -aG docker ubuntu
newgrp docker
docker --version
```

### <mark>Step 2</mark> : Install Docker-Compose
```
sudo curl -L "https://github.com/docker/compose/releases/download/v2.27.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
docker-compose --version
```

### <mark>Step 3</mark> : Check the version of git.
```
git --version | cut -d ' ' -f3
```

### <mark>Step 4</mark> : Clone this repository.
```
git clone https://github.com/soravkumarsharma/Blood-Bank-Management-System.git
```

### <mark>Step 5</mark> : Change the directory.
```
cd Blood-Bank-Management-System
```

### <mark>Step 6</mark> : Create environment variable file.
```
mv .env.example .env
```
### <mark>Step 7</mark> : Start docker containers in detached mode.
```
docker-compose up -d
```

### <mark>Step 8</mark> : Check the containers are up and running.
```
docker ps
```

### <mark>Step 9</mark> : Access this Application.
### Go to your browser, and access this <mark>**Blood Bank Application**</mark> on port <mark>**80**</mark> and <mark>**phpmyadmin**</mark> dashboard on port <mark>**8080**</mark> via the ubuntu instance public IPv4 or IPv6.

#### ***Allow the inbound port 80, 8080 in the security group.***

## Credentials for Admin dashboard.
- <ins>username</ins> : <mark>**admin**</mark>
- <ins>password</ins> : <mark>**admin**</mark>




