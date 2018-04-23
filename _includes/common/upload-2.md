## Summary
I guided you through process of file uploads in this chapter and pointed out some security risks and good practices.
You understand now that file upload is a quiet complicated process and it is even more complicated with file downloads
and caching. You can use JavaScript to check file size or even contents of file on client's computer and to visualize
file upload progress but backend implementation stays practically the same.

**Remember to store files in a way that cannot endanger your server!**

A very common task is upload of images. This is quiet a problem because cameras or cell phones produce quiet large files
(large file size = disk space consumption, large resolution = memory consumption). Therefore it is a good practice
to resize those images and store resized version somewhere on your server (resize of an image is computationally
expensive operation).

### New Concepts and Terms
- file uploads
- file downloads
- `Content-Type` header
- `Content-Disposition` header
- caching

### Control question
- Is it better to store large data objects in database or in file system?
- How do you protect files from being accessible via web server?
- Are there some limits for file uploads?
- Who sets file upload limits?
- Is it safe to store files in file system?