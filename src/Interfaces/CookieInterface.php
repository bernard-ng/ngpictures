<?php
namespace Ng\Interfaces;


interface CookieInterface
{
	public function getValue(string $key, string $value);
	public function write(string $key, string $value);
	public function delete(string $key);
	public function read(string $key);
	public function hasKey(string $key);
}