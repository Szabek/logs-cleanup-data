# Logs Cleanup Data

Logs Cleanup Data is a simple PHP package for managing and working with logs. 

## Installation

You can install this package via Composer. Run the following command to add it to your project:

```bash
composer require szabson/logs-cleanup-data
````

## Example Usage
In the usage example found in the RemoveLogsCommandTest, a logger factory FileLoggerFactory is created, which is used by RemoveLogsCommand to manage logs. The RemoveLogsCommand removes logs older than a specified number of days.

## Requirements
The project is written in PHP and uses PHPUnit for testing. To run the project and tests, you need to have PHP version 8.2 and PHPUnit installed. The project has no external library dependencies.

## Additional content
In addition to deleting logs, I've added some simple log management features that you'll find in FileLogger

## Running Tests
```bash
 vendor/bin/phpunit tests
````
This will run all the tests and display the results in the console.

## Author
This project was created by Daniel Chabowski