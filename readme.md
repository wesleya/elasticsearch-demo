# Elasticsearch Demo

Demo to introduce myself to elastic search. Backend is Laravel, Frontend is Vue.

### To Do:

* update search to only need to match partial
* update search fields to autocomplete with valid results ordered by most popular
* clicking on a result should bring up a detail page where we query for full document data. just display it in a modal or something
* figure out how to properly solve my multiple ports on nginx issue. get rid of my hack
* right a cron to continuously update the latest consumer data
* add more data, right now we only did ~11k of the documents, seems to work fine so do the full 65k now
* figure out how to run elastic and kibana processes where they re-start themselves if they die
* create proper roles/permissions/users for the update script, and the read only api calls

