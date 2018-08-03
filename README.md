# myHammer
My Hammer Test

Welcome, This is Aamir Shoeb.
Before cloning project, please make sure you have PHP 7.1 environment setup on your local server.
Once you clone the project, 
Go to root directory and execute
-> composer install
It will install all the required packages.

Now create .env file on project root and copy .env.dist file contents to it.

On line 16 in .env file, you can see 
DATABASE_URL=mysql://root:@127.0.0.1:3306/myhammer
If you have password set to the database, change it this way, and make URL changes respectively.
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

myhammer is the name of the database, so run the following command, it will create Database.
-> php bin/console doctrine:database:create

Run migrations using following command.
-> php bin/console doc:mig:mig

Run the phpunit test cases by this command,
-> php bin/phpunit

API :
There are 2 ROLES of User
1) USER
2) ADMIN

USER can create and edit the job.
ADMIN can view all jobs.

There are 3 APIs,
1) Create Job
2) Edit Job
3) View All jobs

Every API response will have a HTTP status code, message(also data incase of list).

1) Create Job
It will be saved against email of the user.

Request Format : Json
{
	"email" : "user@gmail.com",
	"title": "Awesome title",
	"description": "some text",
	"jobDate": "2018-10-10 05:10:20",
	"zip" : "10115",
	"categoryId" : 1,
	"jobTypeId" : 1
}

Response :
{
	"code": 200,
	"message": "Job created successfully."
}

Error Response :
{
	"code": 400,
	"message": "Error while creating job. Invalid job selected"
}

2) Edit Job
Request : 
{
	"jobId" : 2,
	"userId" : 2,
	"email" : "user@gmail.com",
	"title": "Awesome title",
	"description": "some text",
	"jobDate": "2018-10-10 05:10:20",
	"zip" : "10115",
	"categoryId" : 1,
	"jobTypeId" : 1
}

Response : 
{
    "code": 200,
    "message": "Job saved successfully."
}

3) Show list of jobs
Request : 
{
	"userId" : 1,
	"servicefilter" : "",
	"regionfilter" : ""
}

Response :
{
    "code": 200,
    "message": "OK",
    "jobs": [
        {
            "JobId": 2,
            "title": "Abtransport, Entsorgung und Entrümpelung",
            "description": "some text",
            "jobDate": {
                "date": "2018-10-10 05:10:20.000000",
                "timezone_type": 3,
                "timezone": "Europe/Berlin"
            },
            "city": "Berlin",
            "zipCode": "10115",
            "country": "Germany",
            "name": "END USER",
            "email": "user@gmail.com"
        },
        {
            "JobId": 3,
            "title": "Sonstige Umzugsleistungen",
            "description": "some text",
            "jobDate": {
                "date": "2018-10-10 05:10:20.000000",
                "timezone_type": 3,
                "timezone": "Europe/Berlin"
            },
            "city": "Berlin",
            "zipCode": "10115",
            "country": "Germany",
            "name": "END USER",
            "email": "user@gmail.com"
        }
    ]
}
