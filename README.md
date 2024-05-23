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
  - Region: ***us-east-1***
  - IAM Role:
    - Create IAM Role with Administrator policy, and attach that role with an EC2 Instance profile.
  
- Install <ins>**AWS CLI**</ins>, <ins>**eksctl**</ins>, <ins>**Kubectl**</ins>, <ins>**Kubectl argo rollouts**</ins> & <ins>**Helm**</ins>

### ***Step*** 1 : Updates the package list.
```
sudo apt update
```

### ***Step*** 2 : Clone this repository.
```
git clone https://github.com/soravkumarsharma/Blood-Bank-Management-System.git
```
### ***Step*** 3 : Change the directory.
```
cd Blood-Bank-Management-System
```

### ***Step*** 4 : Make a script file executable.
```
sudo chmod +x install.sh
```
### ***Step*** 5 : Run the Script.
```
./install.sh
```

### ***Step*** 6 : Check the AWS CLI package Version
```
aws --version | cut -d ' ' -f1 | cut -d '/' -f2
```

### ***Step*** 7 : Check the eksctl package Version
```
eksctl version
```

### ***Step*** 8 : Check the kubectl package Version
```
kubectl version --client | grep 'Client' | cut -d ' ' -f3
```
### ***Step*** 9 : Check the kubectl argo rollouts package Version
```
kubectl argo rollouts version | grep 'kubectl-argo-rollouts:' | cut -d ' ' -f2
```

### ***Step*** 10 : Check the Helm package Version
```
helm version | cut -d '"' -f2
```

### ***Step*** 11 : Create an IAM policy for the AWS Load Balancer Controller that allows it to make calls to AWS APIs on your behalf.
```
cd EKS-Cluster
```
```
aws iam create-policy --policy-name AWSLoadBalancerControllerIAMPolicy --policy-document file://iam_policy.json
```
```
ACC_ID=$(aws sts get-caller-identity | grep 'Account' | cut -d '"' -f4)
```
```
sed -i "s/898855110204/${ACC_ID}/g" cluster.yml
```
```
eksctl create cluster -f cluster.yml
```
```
kubectl get nodes
```
```
kubectl get daemonset -n kube-system
```
```
helm repo add eks https://aws.github.io/eks-charts
```
```
helm repo list
```
```
helm repo update eks
```
```
kubectl apply -f crds.yml
```
```
cd ../Kubernetes/
```
```
helm upgrade -i aws-load-balancer-controller eks/aws-load-balancer-controller \
  -n kube-system \
  --set clusterName=blood-bank-prod \
  --set serviceAccount.create=false \
  --set serviceAccount.name=aws-load-balancer-controller
```
```
helm list --all-namespaces
```
```
VPC_ID=$(aws eks describe-cluster \
    --name blood-bank-prod \
    --query "cluster.resourcesVpcConfig.vpcId" \
    --output text)
```
```
CIDR_RANGE=$(aws ec2 describe-vpcs \
    --vpc-ids $VPC_ID \
    --query "Vpcs[].CidrBlock" \
    --output text \
    --region us-east-1)
```
```
SG_ID=$(aws ec2 create-security-group \
    --group-name MyEfsSecurityGroup \
    --description "My EFS security group" \
    --vpc-id $VPC_ID \
    --output text)
```
```
aws ec2 authorize-security-group-ingress \
    --group-id $SG_ID \
    --protocol tcp \
    --port 2049 \
    --cidr $CIDR_RANGE
```
```
FS_ID=$(aws efs create-file-system \
    --region us-east-1 \
    --performance-mode generalPurpose \
    --query 'FileSystemId' \
    --output text)
```
```
aws ec2 describe-subnets \
    --filters "Name=vpc-id,Values=$VPC_ID" \
    --query 'Subnets[?MapPublicIpOnLaunch==`true`].SubnetId' \
    --output text
```
```
aws efs create-mount-target \
    --file-system-id $FS_ID \
    --subnet-id subnet-EXAMPLEe2ba886490 \
    --security-groups $SG_ID
```
```
sed -i "s/fs-0c3bf86e6fa1a57f6/${FS_ID}/g" pv.yml
```





