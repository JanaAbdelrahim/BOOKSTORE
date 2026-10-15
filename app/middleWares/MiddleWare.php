<?php
interface MiddleWare{
    public function handle(string ...$rules) : void;
}