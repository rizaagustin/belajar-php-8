<?php

function sayHello(string $first, string $middle = "", string $last): void
{
    echo "Hello $first $middle $last" . PHP_EOL;
}
// without named argument
sayHello("Riza","Agustin","Testing");
// error di php 7 first dan last harus di isi jika middle ingin dikosongkan
//sayHello("Riza","Testing");
//sayHello("Riza","","Testing");

// with named argument
sayHello(first: "Riza",middle: "Agustin",last: "Testing");

// bisa acak2an
sayHello(first: "Riza",last: "Testing",middle: "Agustin");

// di php 8 middle bisa tidak dimasukan karena ada nilai default
sayHello(first: "Riza",last: "Testing");
