# JTGC
This utility helps to create a JavaFX GUI layout from json. 


## Example

php class :
```php
use gui;
use jtgc\parser\JTCS;

class Form extends UXForm
{
    public function show()
    {
        $this->layout = new JTCS(new File("./layout.json"))->get([ 300, 300 ]); // [ 300, 300 ] is a size of panel
        parent::show(); // show form

        $this->mySuperButton->on("click", fn() => {
            UXDialog::show("mySuperButton is clicked!"); // show dialog
        });
    }
}
```
layout.json :
```json
[
    {
        "_": "button",
        "text": "test JTGC",
        "size": [50, 70],
        "id": "mySuperButton"
    }
]
```


