{: .note}
The `lastInsertId($sequenceName)` method picks the correct SQL command depending on the SQL server that you are using.
On PostgreSQL, this will be `CURRVAL(seq_name)`. For example On MySQL this will be the `LAST_INSERT_ID()` function
which does not take any arguments and you do not have to pass `$sequenceName` into `lastInsertId()` function in that case.

{: .note.note-cont}
In the above example, I have used two variables `$stmt1` and `$stmt2` for the queries. It is not necessary, because
I don't need `$stmt1` after `$stmt2`, so you can use only a single variable and overwrite it. In fact, it is
better to reuse the same variable if possible.

## Error control and transactions
You already know that you have to enclose database communication [in `try-catch`](../../backend-select/#finalizing) blocks. But what happens when the
first query (insert an address) is accepted and the second one (insert a person) is not? There can be more reasons than
you think for the second `INSERT` command to fail:

- the row you are inserting is not complete (some mandatory column has `NULL` value).
- the row you are inserting has a wrong data-type or range of one or more columns.
- the row you are inserting is in conflict with another row (uniqueness).
- the script is terminated from outside (a problem in another process, hardware failure, electric power loss...).
- the database server goes away -- connection was terminated (i.e. problems with computer network, server crashed or is restarted).

Any of the above would result in a state in which you have the address in the database and not the person.
The user would try to insert the information again, but there will be an unused address record in the `location` table.
Even worse, it might be impossible to insert the address at all if it would violate record uniqueness.

To prevent this and other [inconsistent states](/articles/database-systems/#data-integrity) you
want to enclose both queries into a [*transaction*](/articles/database-systems#transaction).
This will make sure that both queries are either accepted by the database system and both
rows are inserted into their tables or no row is inserted at all after the transaction ends.
