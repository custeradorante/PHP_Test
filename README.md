# PHP test

## 1. Installation

  - create an empty database named "phptest" on your MySQL server
  - import the dbdump.sql in the "phptest" database
  - put your MySQL server credentials in the constructor of DB class
  - you can test the demo script in your shell: "php index.php"

## 2. Expectations

This simple application works, but with very old-style monolithic codebase, so do anything you want with it, to make it:

  - easier to work with
  - more maintainable


## [Bad Practices found and Changes made]
## 1. Redundant calls of Manager class
  - Higher memory usage 

  -> create instances in index.php and passed them to reduce redundancy
## 2. Lack of Parameter Binding on SQL Queries
  - Security risk for SQL Injection

  -> used prepared statements with parameter binding to prevent SQL injection
## 3. No Error Handling
  - Harder to debug and maintain. cannot get proper error messages

  -> Implement error handling using try-catch blocks, especially when dealing with external resources like databases to log and handle errors.
## 4. Repetitive Code
  - Harder to maintain code. In case of change, you will need to modify multiple places

  -> created reusable functions
## 5. No Pagination or Limit in Data Fetching
  - for large datasets, fetching all records can slow down and consume too much memory

  -> implemented limit and offset
## 6. Get all records and loop just to get a certain News Id
  - loop is unnecessary and it is memory consuming

  -> created a function `listCommentsByNewsId` that returns only the records for the specified News Id
  