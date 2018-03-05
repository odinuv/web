## Conclusion
User authentication or even authorisation is complicated. I demonstrated one of the easiest ways how to do it --
you can also hardcode passwords into your source code (do not do that!). Keep in mind that weakest point of
application is probably its user because people are lazy to fabricate new passwords for each website and they share
some passwords with their family or friends. Security measures should also be designed according to the type
of application you are developing (a bank account management application VS discussion board).

Passwords are sent over the network in plain text, it is a good idea to use HTTPS for (at least) registration and
login pages to prevent attackers to sniff the password from network traffic. Still this does not prevent targeting
users of your application by scam login pages which are used to steal their authentication information.

There is a lot more to explore: you probably know sites where you can persist your authentication for duration of days
or even weeks -- ours is forgotten as soon as the visitor closes his browser's window. That can be achieved by setting
special attributes to cookies which hold keys to a sessions. You also probably seen that some sites use global services
like Facebook or Google to provide login functionality, which is good for users who do not want to remember too many
passwords. Totally [different approach](https://jwt.io/) of authentication is used for [single page applications](../javascript/).

Remember that you are responsible for security of your application and also for the data of your users.

### New Concepts and Terms
- authentication
- hash & salt
- $_SESSION
- login
- logout