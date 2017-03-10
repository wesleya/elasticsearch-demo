# Elasticsearch Demo

Demo to introduce myself to elastic search. Following are the steps I used to setup this demo project.

1. [Cloud Server Setup](#cloud-server-setup)
2. [Elasticsearch and Kibana Installation](#elasticsearch-and-kibana-installation)
3. [IPTables Setup](#iptables-setup)
4. [Nginx Config](#nginx-config)
5. [DNS Setup](#dns-setup)
6. [Install HTTPS Certificates](#install-https-certificates)

### Cloud Server Setup

I decided to set up my Elasticsearch instance on a Linode server, but these instructions should work on any Ubuntu Linux machine. If you do decide to go the cloud server route, I was only able to get Elasticsearch running on a 4GB Memory instance at a minimum, about $20 on Linode. This first stage of setup is just installing a few pre-requisites we'll use for the rest of setup.

1. SSH into your new Linode server and install a few basic packages we'll need during setup:
```
//ssh in as root
$ ssh root@45.79.89.118

$ apt-get update
$ apt-get upgrade
$ apt-get install git
$ apt-get install vim
$ apt-get install tmux
```
2. Elasticsearch requires Java, [install it](https://www.digitalocean.com/community/tutorials/how-to-install-java-on-ubuntu-with-apt-get)
```
$ java -version
$ apt-get install default-jre
```
3. Elasticsearch won't let you run it under root user, so let's [create a new user](https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-14-04) to install and run Elasticsearch:
```
// add new user
$ adduser elastic

// move new user to sudo group so we can do admin stuff
$ gpasswd -a elastic sudo
```
4. Add public key for new user:
```
// on my local machine, copy my public key
$ cat ~/.ssh/id_rsa.pub

// on linode server su as new user
$ su - elastic

// make .ssh directory
$ mkdir .ssh
$ chmod 700 .ssh

// paste the public key into authorized_keys
$ vim .ssh/authorized_keys
$ chmod 600 .ssh/authorized_keys

// exit back to root user
$ exit
```
5. Install [bash-it](https://github.com/Bash-it/bash-it). This step is completely optional, I use bash-it to customize my shell:
```
// clone the repo
$ git clone --depth=1 https://github.com/Bash-it/bash-it.git ~/.bash_it

// install
$ ~/.bash_it/install.sh

// re-load profile
$ source ~/.bashrc
```

### Elasticsearch and Kibana Installation

1. Install Elasticsearch ([full instructions](https://www.elastic.co/guide/en/elasticsearch/reference/5.1/zip-targz.html#install-targz)):
```
$ wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-5.1.2.tar.gz
$ sha1sum elasticsearch-5.1.2.tar.gz
$ tar -xzf elasticsearch-5.1.2.tar.gz
$ rm elasticsearch-5.1.2.tar.gz
```
2. Install Kibana ([full instructions](https://www.elastic.co/guide/en/kibana/current/targz.html#targz)):
```
$ wget https://artifacts.elastic.co/downloads/kibana/kibana-5.1.2-linux-x86_64.tar.gz
$ sha1sum kibana-5.1.2-linux-x86_64.tar.gz
$tar -xzf kibana-5.1.2-linux-x86_64.tar.gz
$ rm kibana-5.1.2-linux-x86_64.tar.gz
```
3. Use tmux to create some new terminals we're going to use to run the Elasticsearch and Kibana services
```
// start tmux
$ tmux

// create a new window
ctrl + b, c

// toggle between you're two tmux windows
ctrl + b, n
```
4. Install x-pack
```
// install x-pack plugin for elastic search
$ bin/elasticsearch-plugin install x-pack

// install x-pack plugin for kibana
$ bin/kibana-plugin install x-pack - for the UI side of xpack

- start up elastic search and kibana

// from the elasticsearch tmux window
// runs on localhost:9200
$ elasticsearch-5.1.2/bin/elasticsearch

// from the kibana tmux window
// runs on localhost:5601
$ kibana-5.1.2-linux-x86_64/bin/kibana

// the output from these commands won't return to command line (reason for the separate windows).
```

### IPTables Setup

1. Add IP Table Rules:
```
// check current rules
$ sudo iptables -S

// make sure we don't lock ourselves out while playing around with these rules
$ sudo iptables -A INPUT -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT

// allow ssh connections
$ sudo iptables -A INPUT -p tcp --dport 22 -j ACCEPT
// allow http connections
$ sudo iptables -A INPUT -p tcp --dport 80 -j ACCEPT
// all https connections
$ sudo iptables -A INPUT -p tcp --dport 443 -j ACCEPT

// allow loopback for local host
$ sudo iptables -I INPUT 1 -i lo -j ACCEPT

// default is allow in case we wipe away our changes
$ sudo iptables -P INPUT ACCEPT

// drop everything else
sudo iptables -A INPUT -j DROP
```
2. Save IP rules so they persist on restart
```
// install the iptables-persistent package
$ sudo apt-get update
$ sudo apt-get install iptables-persistent

// save the rules
$ sudo invoke-rc.d iptables-persistent save
```

### Nginx Config

Elasticsearch runs on localhost:9200 by default, and Kibana runs on localhost:5601 by default. We'll use Nginx as a reverse proxy so that we can reach both services through http requests. For example, we'll setup http://kibana.my-project.com to hit the Kibana service, and elastic.my-project.com to hit the Elasticsearch Service.

1. Add nginx repository
```
// open the sources.list file using the command
sudo vim /etc/apt/sources.list

// You can add the Nginx repository links at the bottom of the file. Scroll down to the very bottom of the file and add the two lines below :
deb http://nginx.org/packages/ubuntu/ trusty nginx
deb-src http://nginx.org/packages/ubuntu/ trusty nginx

// save the file
```
2. now update your packages
```
// Download and add the nginx signature key using the command below:
$ wget http://nginx.org/keys/nginx_signing.key
$ sudo apt-key add nginx_signing.key

// update packages
$ sudo apt-get update

// then remove the key file from your home directory
rm nginx_signing.key
```
3. Now that the package list is updated and indexed, you can install Nginx:
```
// install Nginx
$ sudo apt-get install nginx

// verify Nginx installed the version:
$ nginx –v

// need to start service
$ sudo service nginx start
```
4. Get rid of the default Nginx config, we're going to use a custom setup
```
$ mv /etc/nginx/conf.d/default.conf /etc/nginx/conf.default.backup
```
5. Add custom server configs for Kibana
```
// create the new config file
$ sudo vim etc/nginx/conf.d/kibana.conf

// any request to kibana.elastic-search.io will be forwarded to the kibana service running on http://localhost:5601
server {
  listen 80;
  server_name kibana.elastic-search.io;

  location / {
  proxy_pass http://localhost:5601;
  proxy_http_version 1.1;
  proxy_set_header Upgrade $http_upgrade;
  proxy_set_header Connection 'upgrade';
  proxy_set_header Host $host;
  proxy_cache_bypass $http_upgrade;
  }
}
```
6. Add custom server configs for Elasticsearch
```
$ sudo vim conf.d/elastic.conf

// any request to api.elastic-search.io will be forwarded to the Elasticsearch service running on http://localhost:9200
server {
  listen 80;
  api.elastic-search.io;

  location / {
  proxy_pass http://localhost:9200;
  proxy_http_version 1.1;
  proxy_set_header Upgrade $http_upgrade;
  proxy_set_header Connection 'upgrade';
  proxy_set_header Host $host;
  proxy_cache_bypass $http_upgrade;
  }
}
```
7. Restart Nginx
```
$ sudo service nginx restart
```
8. Now you should be ready to access your newly setup Elasticsearch and Kibana instances. You should probably login and change the default username and password
```
user: elastic
pass: changeme
```

### Install HTTPS Certificates

- adding for kibana.elastic-search.io and api.elastic-search.io didn't work because auth failed. when it tried to access the proof folders
- taking down the servers and trying again didn't work because then the verification steps got a 404 since no service is running there
- try adding a default server block for any other domains that just returns some default page if not going to kibana or api sub domains

install certbot
sudo certbot certonly --standalone-supported-challenges http-01

- then use second verification option: "automatically use temp server (standalone)
  - I think because
- then put the subdomain kibana.elastic-search.io

IMPORTANT NOTES:
 - Congratulations! Your certificate and chain have been saved at
  /etc/letsencrypt/live/kibana.elastic-search.io/fullchain.pem. Your cert
  will expire on 2017-05-27. To obtain a new or tweaked version of
  this certificate in the future, simply run certbot again. To
  non-interactively renew *all* of your certificates, run "certbot
  renew"

then repeat for api.elastic-search.io

then update these lines in elastic.conf nginx config

- the 443 port
- the ssl_certs

server {
  listen 443 ssl;
  server_name api.elastic-search.io;

  ssl_certificate /etc/letsencrypt/live/api.elastic-search.io/fullchain.pem;
  ssl_certificate_key /etc/letsencrypt/live/api.elastic-search.io/privkey.pem;

  location / {
  proxy_pass http://localhost:9200;
  proxy_http_version 1.1;
  proxy_set_header Upgrade $http_upgrade;
  proxy_set_header Connection 'upgrade';
  proxy_set_header Host $host;
  proxy_cache_bypass $http_upgrade;
  }
}
