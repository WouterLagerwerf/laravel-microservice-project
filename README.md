# Laravel Microservices Project

This project is a fully functional demo for building a Microservices architecture SaaS E-commerce platform. The following tech stack will be used in this project:
- **Frontend**: Next.js
- **Backend**: Laravel 11
- **Database**: MySQL & DynamoDB
- **Queue**: SQS
- **Cache**: Redis
- **Search**: ElasticSearch
- **CI/CD**: GitHub Actions
- **Containerization**: Docker
- **Orchestration**: Kubernetes
- **Monitoring**: Prometheus & Grafana
- **CDN**: CloudFront
- **DNS**: Route53
- **IaC**: Terraform
- **Secrets Management**: AWS Secrets Manager
- **Logging**: CloudWatch

## Project Structure
High-level project structure is as follows:

![Project Architecture](architecture.png)

### Note
The image above depicts the high-level architecture of the project. The actual project structure may vary. For example, resources like CDN, DNS, etc., are not shown in the image.

## Database Structure
This application introduces the concept of workspaces. Workspaces represent the tenants of the system that utilize the app for E-commerce needs.

Workspaces will act as the programmatic barrier between data of parties. This means that each workspace will have its own schema in the database of a microservice.

### User signs up for the application. Provides Username, Email, Password, and Business name.
- A workspace record will be created in the Workspace service.
- The Workspace service will dispatch events to generate a db schema on each microservice for the workspace.
- After schema creation, a new user record will be created in the Authentication DB schema for the workspace.

Because this project is mainly local, we are going to use the /<workspace_name> to identify which tenant we are working with. Normally, this would be done on the subdomain.

An example of database and workspace resolution:
- User registers with the business name: WOUTERBV.
- After the onboarding process mentioned above, a general endpoint will be made available for this business, in this case: [https://example.com/WOUTERBV](https://example.com/WOUTERBV). This will be the generic endpoint utilized to resolve db schemas.

### An example of the database structure
![Database Structure](db_structure.png)

## Getting Started
To get started with the project, follow the steps below:

### Prerequisites
Make sure you have the following installed on your machine:
- Docker
- Docker Compose
- Node.js
- php >= 8.2
- Composer

### Installation
1. Clone the repository
```bash
git clone https://github.com/WouterLagerwerf/laravel-microservice-project.git
```

2. Change directory to the project root
```bash
cd laravel-microservice-project
```

Optional: If you don't have MySQL running locally, you can use the docker-compose file to start a MySQL container
```bash
docker-compose up -d
```
This will make a MySQL container available and launch a webserver with phpMyAdmin on port 8080

3. Environment setup
Make sure you have a `.env` file in the root of each svc folder. You can copy the `.env.example` file and rename it to `.env`

Make sure each env file has the database pointing to the correct location, and if you want to make use of the queue system, you need to set the queue connection to an active SQS queue.

4. Setting up the database
cd into the workspace svc by running the following command from the root of the project
```bash
cd workspace-svc
```
run the following command to migrate the database
```bash
php artisan db:check-and-create
```
this will create the database and run the migrations


### API Authentication
The API for workspace management uses Laravel Passport Machine to Machine authentication. To authenticate the API, you need to create a client in Laravel Passport. To create a client, run the following command:
```bash
php artisan passport:client --client
```
This will create a client and return the client id and client secret. You can use these credentials to authenticate the API.

### Using the other microservices.
Once the migrations have been run for the workspace svc, you can start using the other services by using the POST `/api/workspaces` endpoint to create a workspace. This will dispatch events to create the database schemas for the workspace in the other applications and create a user in the authentication service.

After which, the password grant type can be used to authenticate the user and start using the other services.

As of 25-05-2024, only the workspace svc and event triggers for db creation in the authentication svc have been implemented.
