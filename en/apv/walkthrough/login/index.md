---
title: Login 
permalink: /en/apv/walkthrough/login/
---

* TOC
{:toc}

# User authentication -- login
This chapter is about means to protect your application from anonymous users which could deliberately
delete random data or pollute your application with spam messages. Until now, your application was publicly 
available to online audience without any possibility to control who is working with stored data.
I want to show you how to store user account data securely (especially passwords) and how to verify
a user which is trying to log into your application. I will not talk about different levels of user
permissions because it would complicate things a lot -- this is called authorisation.

## Storing user data and passwords

### Task -- create a table to store user data in database
Create a table with login or email column and a column to store password in hashed format.

## Registration process

### Task -- create a form for user registration
It should have an input for login or email and two inputs for passwords (all inputs are required).
 
### Task -- process registration with PHP script

## User verification and login

### Task -- create a form for user login with PHP script

## Persisting users between HTTP requests - $_SESSION

### Task -- store information about authenticated user in $_SESSION

## Conclusion

### New Concepts and Terms