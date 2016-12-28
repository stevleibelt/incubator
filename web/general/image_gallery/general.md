# Y.A.I.G. (yet another image gallery)

Yet another image gallery core feature is a client/server based approach to distinguish between hosting of the thumb nails (client) and the hosting of the full image (server).

## Thoughts

* server has a webpage to upload images and structure them in paths
* server has a well configured "highest allowed resolution" and will resize images above (and notify the user)
* server will push new image to each configured client for that path
* client gets notified and will ask the server for a thumb nail image
* client can ask the server for a full image

## Benefits

* server does not know about how to display things in a gallery
* client can deal with displaying the thumb nails 
