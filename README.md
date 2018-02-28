# speed-metrics

Command line tool to check some metrics

## Dependencies
* PHP7.1
* MYSQL

## Prerequsite

### Create mysql database with the following credentials
```$xslt
    'user' => 'root',
    'host' => 'localhost',
    'dbname' => 'speed_metrics',
```
NOTE: password is not required

### Clone repository

```bash
git clone https://github.com/danielkmariam/speed-metrics.git
```

### Change directory

```bash
cd speed-metrics
```

### Composer install

```bash
composer install
```

### Run database migration

Assuming you already have mysql installed and created a database. Run the below command to import tables

```bash
bin/phinx migrate
```

# Running commands

### List all commands

```bash
./cli/metrics
```

### Fetch, aggregate and store data

```bash
./cli/metrics fetch:aggregate:store
```
Note: above command has to run before checking metrics. This populate the database with data.

### Check hourly reading of a specific unit & metric
```bash
./cli/metrics unit:metrics <unit_id>, <metrics>, <date>, <time>
```
example
```bash
./cli/metrics unit:metrics 6 download 2017-02-28 9am
```

### Check hourly Minimum
```bash
./cli/metrics hourly:minimum <unit_id> <metrics> <time>
```
example
```bash
./cli/metrics hourly:minimum 6 download 9am
```

### Check hourly Maximum
```bash
./cli/metrics hourly:maximum <unit_id> <metrics> <time>
```
example

```bash
./cli/metrics hourly:maximum 6 download 9am
```

### Check hourly Mean
```bash
./cli/metrics hourly:mean <unit_id> <metrics> <time>
```
example

```bash
./cli/metrics hourly:mean 6 upload 9am
```

### Check hourly Median 
```bash
./cli/metrics hourly:median <unit_id> <metrics> <time>
```
example

```bash
./cli/metrics hourly:median 6 upload 9am
```

### Check Sample Size
```bash
./cli/metrics sample:size
```

## Future Changes

* Use stream to aggregate data, currently json_decode is used to convert the api response and this might cause big memory issue if the response is very large.
* Use better php algorithm or other performing languages to process the response data and store to the database, current implementations is performance can be improved by introducing concurrency.
* Improve the algorithm to calculate Median, Mean, Min and Max, current implementation is heavily dependent on the mysql methods. Especially the Median algorithm can be improved by using Selection algorithm.
* Improve database schema, perhaps use views to store metrics instead of calculating on the fly.
* Better test coverage

