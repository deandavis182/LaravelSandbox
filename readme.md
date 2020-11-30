# Test Instructions

## For Ubuntu 20 Desktop

- Make sure you have git installed (sudo apt-get install -f git)

- Make sure you have vagrant installed (sudo apt-get install -f vagrant)

- Make sure you have virtualbox installed (sudo apt-get install -f virtualbox)

- mkdir ~/code

- cd ~/code/

- git clone https://github.com/deandavis182/LaravelSandbox.git

- cd LaravelSandbox

- cp Homestead/Homestead.yaml.example Homestead/Homestead.yaml

- cp .env.example .env

- edit Homestead.yaml file @ "folders:map" to point to correct local path of host machine (/home/YourUsernameHere/code/LaravelSandbox)

- edit /ect/hosts file to point medicdigital.test to 192.168.10.10 (unless updated in .yaml file)

- set up an Amazon IAM user w/ access key credentials, set up an s3 bucket and create a bucket policy to allow retrieving objects from anywhere (So we can view the files from web browser)

- update .env AWS credentials to match the s3 bucket & update DB credentials for homestead DB
( Default homestead credentials should be: DB_DATABASE=homestead, DB_USERNAME=homestead, DB_PASSWORD=secret )

- ssh-keygen -t rsa -b 4096 -C "example@email.com"

- vagrant up

After machine is done building, you can visit "http://medicdigital.test/" in your web browser to view the running application.


## For MacOS (Catalina 10.15.7)

- Make sure you have Homebrew installed on your machine ( https://brew.sh )

- Make sure you have git installed (brew install git)

- Make sure you have vagrant installed ( https://vagrantup.com/downloads )

- Make sure you have virtualbox installed ( https://virtualbox.org/wiki/downloads )

- mkdir ~/code

- cd ~/code/

- git clone https://github.com/deandavis182/LaravelSandbox.git

- cd LaravelSandbox

- cp Homestead/Homestead.yaml.example Homestead/Homestead.yaml

- cp .env.example .env

- edit Homestead.yaml file @ "folders:map" to point to correct local path of host machine (/Users/YourUsernameHere/code/LaravelSandbox)

- edit /ect/hosts file to point medicdigital.test to 192.168.10.10 (unless updated in .yaml file)

- set up an Amazon IAM user w/ access key credentials, set up an s3 bucket and create a bucket policy to allow retrieving objects from anywhere (So we can view the files from web browser)

- update .env AWS credentials to match the s3 bucket & update DB credentials for homestead DB
( Default homestead credentials should be: DB_DATABASE=homestead, DB_USERNAME=homestead, DB_PASSWORD=secret )

- ssh-keygen -t rsa -b 4096 -C "example@email.com"

- vagrant up

After machine is done building, you can visit "http://medicdigital.test/" in your web browser to view the running application.


### Unit testing

To run unit tests for this application, the vagrant machine must be up and running. (Currently only testing that files can be uploaded / deleted along with the file's relative DB entry.)

- run command "vagrant ssh". This will get you into the terminal of the vagrant machine.
- run "cd code" to get into the directory where Laravel is installed.
- now you can run the command "phpunit" to run unit tests and ensure everything works as expected before deploying.


#

# Victory Laravel Sandbox Application

This application is designed for testing of Laravel Framework capabilities.  Please submit your changes as a Pull Request.

The framework is [Laravel 6.0.2](https://laravel.com) - this is the most recent LTS (Long Term Service) release of Laravel.  The framework has some additional packages installed which will be discussed below.

## Setup and Installation
_This is tested on MacOS, most *Nix architectures and Windows - there are some extra notes for node development in Windows_
- Install [Vagrant](https://vagrantup.com)
- Install [Virtualbox](https://www.virtualbox.org/wiki/Downloads)
- Check out this repository to ~/code/LaravelSandbox - if you choose a different location you just need to make some changes to `Homestead.yaml`
- `cp Homestead/Homestead.yaml.example Homestead/Homestead.yaml`
- `cp .env.example .env`
- `vagrant up`

Once the machine is up you can log in with `vagrant ssh` and change to the code
directory `cd code` - this directory is a share from the host system.  Here you can run any cli items needed like artisan commands.

## Access to the site
The site will be available at the ip address in Homestead.yaml which currently defaults to `192.168.10.10`.  You can change that if it causes problems in your network.
If you'd like to use an easier address you can make an entry in `/etc/hosts` for something like `sandbox.test`


## Package Creation
A key part of this sandbox is to test the ability to create custom packages.  To that end,
this sandbox comes with [Laravel-Packager](https://github.com/Jeroen-G/laravel-packager) - a 3rtd party
package designed to make package creation easy.  You can bootstrap a new package using this tool:
```
php artisan packager:new VENDOR NAME
```
For instance, try this:
```
php artisan packager:new victorycto mysandbox

```
Once complete there is a directory in your codebase under `/packages` built as `/packages/VENDOR/NAME` - so look for `/packages/victorycto/mysandbox`

_Note: Composer plans to enforce that all vendor and package names be lowercase in a future release, so please stick to that format_

*The repository will ignore the `/packages` directory, so work done here will not be loaded back to the repo*


## The Coding Test
We do not believe in standard coding tests at Victory, but we do want to see and understand your style of coding - we find the best way
of doing that is to see you code a real world example.  You may use whatever tools you have available and build this
in any way you see fit.  

Please fork this repository and do your work.  When done email us with the fork url.

### Build a Service
For this exercise you will build a simple service which can be utilized by the site from any controller.  This is
an image service, designed to ingest images and prepare them for use on the site.  Your service should:
- Accept a multipart form image upload
- Resize / Recompress the image to at least 3 sizes (think thumbnail, small and full).  You may change the image format and compression to best suite use on a website
- Store the image to S3 or GCP cloud storage and create a public url - ideally with a CDN frontend
- Save the image data to a table of your design in the local mysql database
- Make the image available to the frontend

You should be able to accomplish this within the free tier of either cloud service, and provide locations and directions in your code for
any needed setup.  If you need help or a paid account reach out and we will provide it.  

We're looking for best practices, good documentation and testing, and creativity.  
