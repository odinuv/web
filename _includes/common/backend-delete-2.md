## Next Steps
Take a look at the [JavaScript](javascript#using-javascript-to-confirm-user-actions)
article to extend your form with a confirmation popup. It is a good idea to let the user confirm
important information deletion because this action cannot be undone.

### Deleting Referenced Records
There are [foreign keys](/articles/database-tech/#foreign-key-constraint) between the `person` table
and other tables (the `person` table is referenced from the records in the `relation` or the `contact` table).
When you take a look at the *Foreign keys* section of the `contact` table details in the Adminer, you can see
that there is `NO ACTION` defined under the `ON DELETE` event:

![Screenshot - Foreign Key No Action](/common/backend-delete/fk1.png)

This means that if you try to delete a person record, the database server has no defined action to do with contacts
related to it -- the database does not know what to do with person's contacts when that person record ceases to exist.
Because of the foreign key constraint, the `id_person` column in the `contact` table cannot store anything else
than values from the `id_person` column in the `person` table. As a result, the database has to reject
your `DELETE` command.

Of course, it is not meaningful to keep contact entries which do not belong to anyone. We should therefore set
that `ON DELETE` behavior to `CASCADE` (use "Alter" button on right side):

![Screenshot - Foreign Key Cascade](/common/backend-delete/fk2.png)

The `CASCADE` ensures that the `DELETE` command will delete the record
with [**all records depending on it**](/article/database-tech/#integrity-constraints).
You should change this in every table which references `person` table, otherwise you won't be able
to delete persons with entries in those tables.

In other cases you might prefer to break the reference instead of deleting related entries. It is the case
of the [`location` -- `person` relationship](/articles/database-tech/#foreign-key----set-nul-example).
When you want to delete an address which is referenced by a person record, you would rather set the
foreign key deletion behavior for the `id_location` column
in the `person` table to `SET NULL` instead of `CASCADE`. This setting would preserve
a person record and set its `id_location` column to NULL (from now on, you will not know where she lives anymore).
To be able to do this, the `id_location` column must support storing a NULL value.

### Task -- Configure Foreign Keys
Now configure the foreign keys in your database so that you can delete records as needed.

{: .solution}
<div markdown='1'>
If you are stuck, I suggest you configure the following tables and keys:

- table `contact`, key `contact_id_person_fkey` set to `CASCADE`,
- table `meeting`, key `meeting_id_location_fkey` set to `SET NULL`,
- table `person`, key `person_id_location_fkey` set to `SET NULL`,
- table `person_meeting`, key `person_meeting_id_meeting_fkey` set to `CASCADE`,
- table `person_meeting`, key `person_meeting_id_person_fkey` set to `CASCADE`,
- table `relation`, key `relation_id_person1_fkey` set to `CASCADE`,
- table `relation`, key `relation_id_person2_fkey` set to `CASCADE`.
</div>

## Summary
Now you now how to delete records from a database. I have also showed you how to redirect after *POST*
to avoid action confirmation. You should also understand how the foreign keys guard the
consistency of the data and that you need to think what to do with the dependent records -- whether to delete them along
or leave them in the database while removing the link to the deleted record. For a deeper explanation see
the [corresponding article](/article/database-tech/#integrity-constraints). You can also
take a look at the chapter about [login](login) to limit access to this functionality.

### New Concepts and Terms
- Delete
- Hidden input
- Foreign keys
- Redirect
- CASCADE
- SET NULL
