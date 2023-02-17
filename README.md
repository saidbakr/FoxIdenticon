# FoxIdenticon
Simple PHP identicon static class to create fireworks splash avatars

### Usage

Access the `avatar.php` using a URL like:
```
myhost.example/avatar.php?str=someUserName&s=10
```
The parameter `s` stands for **size** and the size here is an operand multiplied by 15. In other words, `10` means the width and the height of the image will be 150px

```php
<?php
namespace saidbakr;
require_once('FoxIdenticon.php');
use \saidbakr\FoxIdenticon;
FoxIdenticon::create($_GET['str']??null,$_GET['s']??null,true,false);

```
**Parameters**

1- The string that is going to be hashed to generate lines
2- The Int or float size of the image 
3- `hasTrimmedBorder` the private property boolean default is false -No border-
4- `thickBorder` the private property boolean to make the border thick or thin, default is false -thin border-

![Avatar](avatar.png)
![Avatar](avatar1.png)
![Avatar](avatar2.png)
![Avatar](avatar3.png)
![Avatar](avatar4.png)

**With border samples:

![Avatar](avatar5.png)
![Avatar](avatar6.png)
![Avatar](avatar7.png)
