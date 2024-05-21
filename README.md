<div align="center">
  <img src="./Blood_Bank/images/favicon.png" alt="logo" width="80" height="80">
  <h2>Blood-Bank-Management-System</h2>
  <h3>|| <ins>Setup Guide</ins> ||</h3>
</div>

### Prerequisites:
- Ubuntu Instance
  - Instance Type: ***t2.medium***
- Install <ins>**Docker**</ins>, <ins>**Docker-Compose**</ins> & <ins>**Git**</ins>

### ***Step*** 1 : Install Docker
```
sudo apt update
sudo apt install -y docker.io
sudo usermod -aG docker ubuntu
newgrp docker
docker --version
```

### ***Step*** 2 : Install Docker-Compose
```
sudo curl -L "https://github.com/docker/compose/releases/download/v2.27.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
docker-compose --version
```

### ***Step*** 3 : Check the version of git.
```
git --version | cut -d ' ' -f3
```

### ***Step*** 4 : Clone this repository.
```
git clone https://github.com/soravkumarsharma/Blood-Bank-Management-System.git
```

### ***Step*** 5 : Change the directory.
```
cd Blood-Bank-Management-System
```

### ***Step*** 6 : Create environment variable file.
```
mv .env.example .env
```
### ***Step*** 7 : Start docker containers in detached mode.
```
docker-compose up -d
```

### ***Step*** 8 : Check the containers are up and running.
```
docker ps
```

### ***Step*** 9 : Access Application.
### Go to your browser, and access this <ins>**Blood Bank Application**</ins> on port <ins>**80**</ins> and <ins>**phpmyadmin**</ins> dashboard on port <ins>**8080**</ins> via the ubuntu instance public IPv4 or IPv6.

#### ***Allow the inbound port 80, 8080 in the security group.***

## Credentials for Admin dashboard.
Access admin_test.php in your browser by typing [admin_test.php](http://localhost:80/admin_test.php) in the address bar. This will automatically execute the PHP code inside the file and insert admin credentials into your MySQL database

- <ins>username</ins> : **sorav**
- <ins>password</ins> : **root**

<hr />

<div align="center">
  <img src="./Blood_Bank/images/eks.png" alt="logo" width="60" height="60">
  <h2>Deploy the BBMS on an Amazon EKS Cluster</h2>
  <h3>|| <ins>Setup Guide</ins> ||</h3>
</div>

### Prerequisites:
- Ubuntu Instance
  - Instance Type: ***t2.medium***
  - Root Volume: ***20GiB***
  - IAM Role:
    - Create IAM Role with Administrator policy, and attach that role with an EC2 Instance.
- Install <ins>**AWS CLI**</ins>, <ins>**eksctl**</ins>, <ins>**Kubectl**</ins> & <ins>**Helm**</ins>


