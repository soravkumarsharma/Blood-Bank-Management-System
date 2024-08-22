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

### ***Step*** 2 : Fork & Clone this repository.
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
### ***Step*** 12 : Retrieve the AWS account ID of the currently authenticated user.
```
ACC_ID=$(aws sts get-caller-identity | grep 'Account' | cut -d '"' -f4)
```
### ***Step*** 13 : Replace the Account ID.
```
sed -i "s/898855110204/${ACC_ID}/g" cluster.yml
```
### ***Step*** 14 : Create an EKS cluster. 
 - Note: wait for 10-15 minutes for the provisioning process to complete
```
eksctl create cluster -f cluster.yml
```
### ***Step*** 15 : Check all the worker nodes. 
```
kubectl get nodes
```
### ***Step*** 16 : Check Addons. 
```
kubectl get daemonset -n kube-system
```
### ***Step*** 17 : Add the eks-charts to the helm repository.
```
helm repo add eks https://aws.github.io/eks-charts
```
### ***Step*** 18 : Check the repo is added or not.
```
helm repo list
```
### ***Step*** 19 : Update your local repo to make sure that you have the most recent charts.
```
helm repo update eks
```
### ***Step*** 20 : Before installing the aws load balancer controller, first apply the crds.yml file.
```
kubectl apply -f crds.yml
```
### ***Step*** 21 : Install the aws-load-balancer-controller.
```
helm upgrade -i aws-load-balancer-controller eks/aws-load-balancer-controller \
  -n kube-system \
  --set clusterName=blood-bank-prod \
  --set serviceAccount.create=false \
  --set serviceAccount.name=aws-load-balancer-controller
```
### ***Step*** 22 : Verify that the controller is installed.
```
helm list --all-namespaces
```
### ***Step*** 23 : Change the Directory.
```
cd ../Kubernetes/php
```
### ***Step*** 24 : Create an EFS.
- Retrieve the AWS VPC ID.
```
VPC_ID=$(aws eks describe-cluster \
    --name blood-bank-prod \
    --query "cluster.resourcesVpcConfig.vpcId" \
    --output text)
```
- Retrieve the AWS VPC CIDR Range.
```
CIDR_RANGE=$(aws ec2 describe-vpcs \
    --vpc-ids $VPC_ID \
    --query "Vpcs[].CidrBlock" \
    --output text \
    --region us-east-1)
```
- Create Security Group for the EFS.
```
SG_ID=$(aws ec2 create-security-group \
    --group-name MyEfsSecurityGroup \
    --description "My EFS security group" \
    --vpc-id $VPC_ID \
    --output text)
```
- Add the Inbound rules into the Security Group.
```
aws ec2 authorize-security-group-ingress \
    --group-id $SG_ID \
    --protocol tcp \
    --port 2049 \
    --cidr $CIDR_RANGE
```
- Create the EFS.
```
FS_ID=$(aws efs create-file-system \
    --region us-east-1 \
    --performance-mode generalPurpose \
    --query 'FileSystemId' \
    --output text)
```
- Retrieve the Public Subnet ID.
```
aws ec2 describe-subnets \
    --filters "Name=vpc-id,Values=$VPC_ID" \
    --query 'Subnets[?MapPublicIpOnLaunch==`true`].SubnetId' \
    --output text
```
- Mount the Public Subnet ID to the EFS.
```
aws efs create-mount-target \
    --file-system-id $FS_ID \
    --subnet-id subnet-EXAMPLEe2ba886490 \
    --security-groups $SG_ID
```
- Create Secrets in ***Blood-Bank-Management-System***.
```
echo $FS_ID
Note: copy the EFS ID
Go to Repo Settings -> Go to Secrets and Variables -> Actions -> New Repository Secret.
Secret Name: EFS_ID
Secret Value: paste the copied EFS ID.
```
- Create Certificate from AWS Certificate Manager.
```
After Certificate is created then copy the Certificate ARN.
Go to Repo Settings -> Go to Secrets and Variables -> Actions -> New Repository Secret.
Secret Name: CERT_ARN
Secret Value: paste the copied Certificate ARN.
```
- Create the API TOKEN for Github.
```
Create API TOKEN Secret for The CI pipeline.
Go to Profile -> Settings -> Go to Developer Settings -> Go to Personal Access Tokens -> Generate Classic Token -> Copy the Token
Secret Name: API_TOKEN_GITHUB
Secret Value: paste the copied token.
```

- Create the Docker Hub Secrets for CI Pipeline.
```
Create DOCKERHUB_USERNAME Secret for The CI pipeline.
Go to Repo Settings -> Go to Secrets and Variables -> Actions -> New Repository Secret.
Secret Name: DOCKERHUB_USERNAME
Secret Value: enter your dockerhub username

Create DOCKERHUB_TOKEN Secret for The CI pipeline.
Go to [Docker](https://hub.docker.com) -> Go to profile -> Go to My account -> Go to Security -> Create Access Token -> Copy the Token
Go to Repo Settings -> Go to Secrets and Variables -> Actions -> New Repository Secret.
Secret Name: DOCKERHUB_TOKEN
Secret Value: paste your copied token.
```

- Push the changes to the Git Repository.
```
git add .
git commit -m "manifest files modified"
git push origin main
```
- Change the Directory.
```
cd ../..
```
### ***Step*** 25 : Install ArgoCD.
```
kubectl create namespace argocd
kubectl apply -n argocd -f https://raw.githubusercontent.com/argoproj/argo-cd/stable/manifests/install.yaml
```
- Expose the service of ArgoCD Server as a Classic Load Balancer.
```
kubectl patch svc argocd-server -n argocd -p '{"spec": {"type": "LoadBalancer"}}'
```
- Retrieve the Load Balancer DNS.
```
kubectl get svc -n argocd
```
- Retrieve the ArgoCD Server initial password.
  - Login into the Server using the Load Balancer DNS url.
```
kubectl get secret/argocd-initial-admin-secret -n argocd -o jsonpath="{.data.password}" | base64 -d; echo
```
### ***Step*** 26 : Install Argo Rollouts.
```
kubectl create namespace argo-rollouts
kubectl apply -n argo-rollouts -f https://github.com/argoproj/argo-rollouts/releases/latest/download/install.yaml
```
- Before Apply the ApplicationSet manifest file to the kubernetes cluster, Firstly change the git repo url, and then Apply the manifest file.
```
kubectl apply -f ApplicationSet.yml
```
### ***Step*** 27 : Argo Rollouts Dashboard.
- Make sure that the inbound port 3100 is opened into the EC2 instance.
```
kubectl argo rollouts dashboard
```

## Credentials for Admin dashboard.
Access admin_test.php in your browser by typing admin_test.php in the address bar. This will automatically execute the PHP code inside the file and insert admin credentials into your MySQL database

- <ins>username</ins> : **sorav**
- <ins>password</ins> : **root**

## Architecture for BBMS

![Untitled Diagram](https://github.com/user-attachments/assets/b6bc64eb-c343-4934-9ef1-6c5062d26561)





