Either SQL query from my example may raise an exception and the program execution will jump into the `catch` block. When this
happens, the database will revert to the previous state thanks to `rollback` command. On the other hand, when everything goes
smooth, the changes are store permanently in the database using `commit` command.

{: .note}
The database system executes the SQL commands in transaction right away -- it does not wait until the `commit` command.
The most important moment is when you `begin` the transaction, at that moment the database begins to record
your changes and you can revert to **that state** using `rollback` command. Your changes in database are available to you
during the transaction but no one else can see them.

## Task -- Play around with transactions
Take the [first PHP script](#php-code) above and complete it so that it inserts data into the `location` and `person` tables. Or create your own with full working forms. Make sure to use the version without transactions. Then try to break
the second `INSERT` command (just make an error in the SQL command spelling, e.g. `IxSERT` instead of
`INSERT`). Observe the changes in the database. Then add the transaction commands (`begin`, `commit`, `rollback`)
and again observe what changes are made to the database. Do you notice the change of behavior?
Can you explain why it changed?

<div class="solution">
    <p markdown="1">
        If you run the the script without the transaction commands, the first `INSERT` succeeds and the the location
        will be inserted into the `location` table. It will remain there even if the other insert fails.
        When you add the transaction commands, the behavior will change. If the first INSERT fails, and
        raises an exception, the script will jump to `catch` statement and issue the `rollback` command.
        This will roll back all SQL commands from the beginning of the transaction -- in this case the
        insert into the `location` table. Therefore the database will not contain the orphaned location record.
    </p>
</div>

## Summary
In this chapter I demonstrated how to insert multiple records which have some dependence among them. This requires
using a *last insert id* value for the current database session. In the second part
I described the importance of using transactions when inserting multiple rows.

### New Concepts and Terms
- Generated sequence
- Database session
- `PDO::lastInsertId()`
- Transaction

### Control question
- Why not use MAX() to obtain ID of last inserted row?
- How to determine the order of record insertion (e.g. insert address or person first)?