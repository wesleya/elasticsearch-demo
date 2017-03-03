# Elasticsearch Demo

Demo to introduce myself to elastic search. Backend is Laravel, Frontend is Vue.

### To Do

* bug for too many results
* feedback for no results
* escape keyboard on enter
* don't send request if empty search
* add loading icon
* validate input more carefully since the api is open to scraping (no csrf)

## Setup

todo, explain exactly what we're going to setup. probably explain something about how i'm a developer and don't have a ton of experience with setting up the hardware, which is why I wanted to install on a server vs using the SASS. or maybe this should go in the project description.

* cloud server
* nginx config
* iptables
* dns
* elasticsearch and kibana
* demo site

### Prerequisites

* Linode Server with 4GB Memory - This will run you ~$20/month. But it's the cheapest server I can find that comes with 4GB memory. I wasn't able to get Elasticsearch running with anything less.
* Domain Name - This is optional, but my setup steps include how to setup different subdomains for Elasticsearch, Kibana, and a demo site. About ~20/month.

### Linode Server

todo: summary of this first step

1. SSH into your new Linode server and install a few basic packages we'll need:
```
//ssh in as root
$ ssh root@45.79.89.118

$ apt-get update
$ apt-get upgrade
$ apt-get install git
$ apt-get install vim
$ apt-get install tmux

// install java (based on this)
$ java -version
$ apt-get install default-jre
```

2. Create new user. Elasticsearch won't let you run it under root user, so let's create a new user to install and run Elasticsearch under:
```
// add new user
$ adduser elastic

// move new user to sudo group so we can do admin stuff
$ gpasswd -a elastic sudo
```

3. Add public key for new user:
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

4. Install bash-it. This step is completely optional, I use bash-it to customize my shell:
```
// clone the repo
$ git clone --depth=1 https://github.com/Bash-it/bash-it.git ~/.bash_it

// install
$ ~/.bash_it/install.sh

// re-load profile
$ source ~/.bashrc
```

###Install Elastic Search Services

1. Install Elasticsearch:

```
$ wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-5.1.2.tar.gz
$ sha1sum elasticsearch-5.1.2.tar.gz
$ tar -xzf elasticsearch-5.1.2.tar.gz
$ rm elasticsearch-5.1.2.tar.gz
```

2. Install Kibana (based on this):

```
$ wget https://artifacts.elastic.co/downloads/kibana/kibana-5.1.2-linux-x86_64.tar.gz
$ sha1sum kibana-5.1.2-linux-x86_64.tar.gz
$tar -xzf kibana-5.1.2-linux-x86_64.tar.gz
$ rm kibana-5.1.2-linux-x86_64.tar.gz
```

3. tmux some windows so we can run these services (later on I'll have to figure out how to run these as actual monitored services). Create one window to run elasticsearch, another window to run kibana, and another window to be able to edit configs

4. install x-pack

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

### Setup IP Tables

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

// todo: add this after the port number in order to make it ip specific: -s XXX.XXX.XXX.XXX
// use my work ip address for kibana
// use the forge server ip address for elasticsearch

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


### Setup Nginx 

Install nginx using the instructions here
- get rid of the default server config

$ mv /etc/nginx/conf.d/default.conf /etc/nginx/conf.default.backup

- Add custom server configs for kibana and elastic search

// etc/nginx/conf.d/kibana.conf
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

// conf.d/elastic.conf
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

- Restart Nginx

$ sudo service nginx restart

- Login to Kibana

// now loging with the default credentials
user: elastic
pass: changeme

// now change the default credentials

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
