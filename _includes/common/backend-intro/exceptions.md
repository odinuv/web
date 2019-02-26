A very special control structure is the *try-catch* statement. This structure is used to catch
[*Exceptions*](http://php.net/manual/en/language.exceptions.php) which are [*thrown*](http://php.net/manual/en/internals2.opcodes.throw.php)
from a code inside the *try* block. *Throwing an exception* means that the code execution is stopped in the *try* block
and an error object is created and passed into the *catch* block. The *exception* is simple [object](../objects/) which
inherits from or is instance of *Exception* class, the advantage of exception object is that the programmer can create
his custom exception with unique payload for given situation or he can distinguish among exceptions just by detecting
its *data-type* (by chaining *catch* statements). When no exception is thrown inside *try* block, the *catch* block is
not executed at all.

~~~ php?start_inline=1
try {
    //preparation code
    if($somethingIsWrong) {
        //precondition failed, we need to throw an exception
        throw new Exception('Some very serious error.');
    }
    //code after exception is not executed when the exception is thrown
} catch (Exception $e) {
    //handle the exception stored in variable $e
    //this block is not executed when no exception was thrown
}
~~~

You can create your own exceptions by extending the *Exception* class:

~~~ php?start_inline=1
class CustomException extends Exception {
    //custom methods or properties
}

try {
    throw new CustomException('Some very serious error.');
} catch (CustomException $e) {
    //handle the custom exception
} catch (Exception $e) {
    //handle general exception
}
~~~

{: .note}
These examples are not the best, the exception is usually thrown by a function or a method from a library which is used
inside your *try* block. It is a method of communication between your code and other programmer's code.

Exceptions are a better way to signalize errors. You can use [`trigger_error()`](http://php.net/manual/en/function.trigger-error.php)
function, but such error is not recoverable -- you cannot attach specific functionality for given situation, although
you can [define](http://php.net/manual/en/function.set-error-handler.php) general error handler for all errors.
Exception allows you to give the code a chance to recover in defined way and continue, or display some error message
in controlled way.

There is a non-mandatory extension of *try-catch* statement called *finally*. This block is always executed after
either *try* or *catch* statement and is intended as clean-up block:

~~~ php?start_inline=1
try {
    //code
} catch (Exception $e) {
    //handle possible exception
} finally {
    //clean-up code
}
~~~

## Handling exceptions
The simplest handler is `die($e->getMessage());`, but you can use it only for development purposes. Actual application
running on production server should log the exception into a logfile and display reasonable error message or try to
recover and continue.

{: .note}
Reasonable means that it should be readable for general visitor -- i.e. no technical details that would scare the
visitor or compromise security of your application.

## Summary
Exceptions are a good way how to signalize unexpected behaviour or input. You do not have to think hard about defining
special meanings for return values. It also enriches the ways how to express yourself in programming language.

### New Concepts and Terms
- Try-Catch
- Exceptions
- Finally

### Control question
- How should an exception be handled?
- Is the *finally* statement always executed and is it mandatory?
- Can you use *Exception* class without inheriting from it?
