# Pretty Tags for Modx Revolution


## Quick start
* Install package
* Add resource for tags and set it's id in system setting `prettytags_resource_id`
* Create TV for tags with type `prettytags` for resource pages
* Create tags in Pretty Tags admin page

### Tags page
Tags page catch tags in format `https://yoursite/your-page-tags-url/some-tag`

You can set next placeholder in template:
```
[[+pretty_tags_id]]     
[[+pretty_tags_alias]]  
[[+pretty_tags_name]]   
[[+pretty_tags_description]]
```

For get resource with tags you can use pdoTools or another, like this:
```
[[!pdoResources?
    &parents=`3`
    &includeTVs=`tags`
    &tpl=`@INLINE <p>[[+pagetitle]]</p>`
    &where=`{ "tags:LIKE":"%[[+pretty_tags_id]]%" }`
]]
```

### One resource
For getting resource's tags, you need use snippet `prettyTagsResource`
Like this:
```
[[!prettyTagsResource?
    &limit=`0`
    &input=`[[*tags]]`
]]
```
### Tag Cloud
For tag cloud you need use snippet `prettyTagsCloud`, like this:
```
[[!prettyTagsCloud?
    &tpl=`tpl.prettyTags.item`
    &sortby=`name`
    &sortdir=`ASC`
    &limit=`10`
]]
```
