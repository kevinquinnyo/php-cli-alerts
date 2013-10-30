php-cli-alerts
==============

php cli terminal class

usage:

$term = new Terminal();

$term->alert("INFO", "This is just informative.\n\n");

$term->alert("ERROR", "This will be sent to STDERR\n\n");

$term->color("blue", "This is blue text!\n\n");

$arr = array("foo" => "bar", "baz" => "quux");

$term->doList("red", "blue", ":" "", $arr);


Feel free to fork, there's plenty of room for improvement.
