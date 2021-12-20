# HealthCheck API for 1PT

## Installation

Run

    $ git clone https://github.com/coolms/1pt-test.git

to get the project on your machine. This will create a directory called 1pt-test wherever you run the command.

The simplest way to install HealthCheck API app is to use [Docker](https://www.docker.com/). If you don't have Docker yet, download it following the instructions on
https://www.docker.com/.

Then cd to 1pt-test/docker directory and run

    $ docker-compose up --build -d

### Local domains

In `/etc/hosts` or `%SystemDrive%:\Windows\System32\drivers\etc\hosts` add the line `127.0.0.1 phc.local`

More API endpoints can be found on `http://phc.local/api/doc` page
