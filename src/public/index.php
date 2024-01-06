<?php
class ClassA
{
	public function __construct(public int $x, public int $y)
	{
	}
	public function foo():string
	{
		return 'foo';
	}
	public function bar():object
	{
		return new class($this->x, $this->y) extends ClassA {
			public function __construct(public int $x, public int $y)
			{
				parent::__construct($x, $y);
				echo $this->foo();
			}
		};
	}
}

?>

<pre>
	<?php

$a = new ClassA(2,3);
print_r($a->bar());
 ?>

</pre>