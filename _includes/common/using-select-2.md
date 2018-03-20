{: .note}
Notice that I used a different way to pass ID of person to the script in hidden form field. This means, that the
ID of a person is not visible in URL after form submit and you can find it in *POST* data using `getParsedBody()`
method. Other way is to append the ID to `action` attribute of the form as in previous article about
[person update](../backend-update/).

Finally done. Take a look into your browser's developer tools (F12) and observe what the browser sends when you
select different location IDs. Also note HTTP methods and [immediate redirection](../backend-delete/#redirect-after-post)
after update script:

{: .image-popup}
![Select parameters](/common/backend-update/select-values.png)

{: .note}
Because this is quiet small piece of functionality, try to incorporate this script into person update module.

## Optgroups
Just to be complete: to group `select` element `option`s use `optgroup` tag:

{% highlight html %}
{% include /common/backend-update/optgroup.html %}
{% endhighlight %}

## Summary
This walkthrough chapter should help you to understand name-value concept of `select` element which is not that clear
at first sight as with simple text inputs. You can try to use multiple select element and update some M:N cardinality
relationship like persons attending a meeting. This leads to [passing arrays chapter](../passing-arrays/).

### New Concepts and Terms
- optgroup