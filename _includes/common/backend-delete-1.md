This section is dedicated to teach you how to delete database records.
Deleting something from a database is permanent and cannot be undone unless you have a database
backup. Be careful about what you delete, though do not be afraid to experiment with
your project since [you do have a backup for it](todo).

## Uniquness
The [SQL `DELETE`](../database-intro/#delete) command is already familiar to you.
One thing you should think of is how to determine which rows to delete. The most common action
is deletion of a single row. Each table should have a
[primary key](/articles/relational-database/#key) which identifies
each row with a unique value or a set of values. Therefore, you should use it to delete rows.

Be especially careful about compound keys. For example, you cannot delete a single person record by entering
its `first_name` and `last_name`. There is unique key on `first_name`,`last_name` and `nickname`
columns. This means that the combination of `first_name`,`last_name` and `nickname` are guaranteed to be unique,
but `first_name` and `last_name` are **not guaranteed to be unique**. These two attributes
of a person **can be shared** among many records in database. Notice the use of words "guaranteed" and
"can be". It may well happen that your database contains only a single person with a particular
`first_name` and `last_name`. But you cannot rely on such assumptions in your application code, because you don't
know what data will be in the database in future. To create a **reliable application**, you must
use the database keys correctly!

It is also worth noting that before you allow users of your application to modify or even
delete information, you should first
take steps to [authenticate](../login/) and authorize them.
