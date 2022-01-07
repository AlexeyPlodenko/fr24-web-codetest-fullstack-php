# Flightradar24 Fullstack/PHP Code Test

## Overview

You are tasked with displaying real-time flight events on a simple webpage. This zip contains a bare-metal application. 

Please complete as many tasks as you are able to within the given time window, but don't sacrifice code quality for speed. Don't worry if you don't have time to complete all tasks.

After your tasks are completed please zip your entire code folder, including .git history and send your submission to your interviewer.

## Additional Requirements

Before you begin, it is expected that you initialise it as a local git repository ( git init ) and commit the existing code to the master branch. 

We recommend you target latest Chrome or Firefox browsers, using ES6-standard JavaScript where possible.

If you reuse somebody else's code for part of your solution, please attribute accordingly in your code.

### PHP 7.x

Please use PHP 7.x for your submission. For ease of development we recommend you use the PHP CLI's built in development server.

Most extensions should be available through your OS's package manager, but you can install via pecl/pear as an alternative

The following extensions are required:

* php-sqlite3
* php-json

Feel free to make use of others if you think they are necessary.

### Preparation

```bash
cd /path/to/project/php

# create the class autoloader and install phpunit under ./vendor:
php composer.phar install

# start development server
php -S localhost:8080
```

You then browse to http://localhost:8080 to preview rendered php content.

## Tasks

Using git, create a branch based on master called "feature/flight-event-service". After completing the following tasks to the best of your abilities commit your changes to this branch ( with as many commits as you think is necessary ).

### Task #1

The base project contains a FlightEvents class which generates a variable length array list of aviation event strings:

```php
FlightEvents::fetch();

# returns, for example -->
array (
    0 => 'Flight IB8213 is taking off from KRK destined for TXL',
    1 => 'Flight AF1096 from LCA has landed at BER',
    2 => 'Flight SK4345 is taxiing to runway at BMA',
    3 => 'Flight LX7485 from BEG is cruising en route to MMX at 33900 ft',
    4 => 'Flight LH6066 was seen on ground at ARN',
    5 => 'Flight SK6010 from BMA has landed at BEG',
    6 => 'Flight AF8496 is taxiing to runway at BMA',
    7 => 'Flight KL4319 from KRK is in a holding pattern awaiting arrival at ISB',
    8 => 'Flight LX8265 from TXL has started approach to BMA',
)
```
Using this events class, create a simple object oriented REST API with a route for http://localhost:8080/flight/events ( or /flight/events.php ) that will return this list as a json array.

The json response should have the following format:
```json
{
    "status": "ok",
    "data": [
        "Flight IB8213 is taking off from KRK destined for TXL",
        "Flight AF1096 from LCA has landed at BER",
        "Flight SK4345 is taxiing to runway at BMA",
        "Flight LX7485 from BEG is cruising en route to MMX at 33900 ft",
        "Flight LH6066 was seen on ground at ARN",
        "Flight SK6010 from BMA has landed at BEG",
        "Flight AF8496 is taxiing to runway at BMA",
        "Flight KL4319 from KRK is in a holding pattern awaiting arrival at ISB",
        "Flight LX8265 from TXL has started approach to BMA"
    ]
}
```
( status should be "ok" if the query is a success, or "error" on failure )

### Task #2

Add a "limit" parameter, that will restrict the maximum number of results to the specified value, e.g. /flight/events?limit=10. If no limit is specified, then a maximum of 20 results should be sent to the client.

### Task #3

Edit the dashboad in php/dash/ ( accessible via http://localhost:8080/dash/ ) and create an event poller that sends a request to the /flight/events api endpoint every 5 seconds and presents a list of the 50 most recent events on the dashboard - using JavaScript ( preferably ES6 ), HTML5 and CSS3.

Make sure events are listed from newest to oldest, with an alternating white and light grey background for each row. The first item in the list should have your favorite color-code as a text color ( as long as it stands out! ).

### Task #4

Write 2 unit tests against your code and/or the FlightEvents class. You can place your test cases under php/tests/ and execute them using phpunit:

```bash
./vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox tests/
```
If you prefer to write test cases using another tool, please update composer.json to install the required dependencies.

### Task #5

Add the svg logo to the brand ( images/logo_fr24.svg or something of your own choosing! )

## Bonus Tasks

If you have time to spare, feel free to take a look at the following additional tasks. :-)

### Extra task #1

Create an additional API route for returning data about specific airports. A client should be able to query by ICAO code, and return a single json response using data from the included sqlite3 database found in db/airports.db. Alternatively you can parse the csv file at the same location.

```sql
-- sqlite> .schema airports
CREATE TABLE airports ( 
    iata text primary key, 
    icao text NOT NULL UNIQUE, 
    name text NOT NULL, 
    latitude real, 
    longitude real, 
    size integer not null 
);
```
For example: /airport/detail?icao=ARN
```json
{
    "status": "ok",
    "data": {
        "iata": "ESSA",
        "icao": "ARN",
        "name": "Stockholm Arlanda Airport",
        "latitude": 59.651939,
        "longitude": 17.91861,
        "size": 410911
    }
}

```
( status should be "error" if the ICAO is not found )

### Extra task #2

Allow a user to click on airport ICAO in the events list and get more information about the airport ( using a request to the /airport/detail api endpoint ). For example in this event: "Flight AF1096 from LCA has landed at BER", both LCA and BER are airport ICAO codes.

### Extra task #3

Merge your feature branch back into master

## Gratitude

As a very small token of gratitude for spending time on this, we'd be happy to send you a Flightradar24 keychain and lanyard. If you're interested in this, please provide your home address when you hand in your solution.
