![Avatar](avatar.png)
![Avatar](avatar1.png)
![Avatar](avatar2.png)
![Avatar](avatar3.png)
![Avatar](avatar4.png)

**With border samples:**

![Avatar](avatar5.png)
![Avatar](avatar6.png)
![Avatar](avatar7.png)
# FoxIdenticon
Simple PHP identicon static class to create fireworks splash avatars

### Usage

Access the `avatar.php` using a URL like:
```
myhost.example/avatar.php?str=someUserName&s=10
```
The parameter `s` stands for **size** and the size here is an operand multiplied by 15. In other words, `10` means the width and the height of the image will be 150px

**New**
Introduced new URL parameters in the example `avatar.php` to allow more control on the generated image.

`b` when it is set, it generates border.
`t` when it is set, it generates thick border
Example:
```
myhost.example/avatar.php?str=someUserName&s=10&b&t
// A thick border is generated.

myhost.example/avatar.php?str=someUserName&s=10&b
// A the default thin border is generated.

myhost.example/avatar.php?str=someUserName&s=10&t
// There is no any border will be generated, becuase the b parameter is not set.
```


```php
<?php
namespace saidbakr;
require_once('FoxIdenticon.php');
use \saidbakr\FoxIdenticon;
FoxIdenticon::$salt = 'SomeSaltString'; // Optional to get unique output.
FoxIdenticon::create($_GET['str']??null,$_GET['s']??null,true,false);

```
**Parameters**

1- The string that is going to be hashed to generate lines

2- The Int or float size of the image 

3- `hasTrimmedBorder` the private property boolean default is false -No border-

4- `thickBorder` the private property boolean to make the border thick or thin, default is false -thin border-

-----------

**Public Properties**

1- `salt` Optional string public property to salt the input string, if you wish unique output for your app.

