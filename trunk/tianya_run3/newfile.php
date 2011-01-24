<?php
class Counter
{    private static $c = 0;
    /** Increment counter
     * @final
     * @static
     * @access  public
     * @return  int */    final public static function increment(){ return ++self::$c; }
}
// Create an instance of the Reflection_Method class
$method = new ReflectionMethod('Counter','increment');
// Print out basic information
printf( "===> The %s%s%s%s%s%s%s method '%s' (which is %s)\n" .
    "     declared in %s\n" .
    "     lines %d to %d\n" .
    "     having the modifiers %d[%s]\n",
        $method->isInternal() ? 'internal' : 'user-defined',
        $method->isAbstract() ? ' abstract' : '',
        $method->isFinal() ? ' final' : '',
        $method->isPublic() ? ' public' : '',
        $method->isPrivate() ? ' private' : '',
        $method->isProtected() ? ' protected' : '',
        $method->isStatic() ? ' static' : '',
        $method->getName(),
        $method->isConstructor() ? 'the constructor' : 'a regular method',
        $method->getFileName(),
        $method->getStartLine(),
        $method->getEndline(),
        $method->getModifiers(),
        implode(' ', Reflection::getModifierNames($method->getModifiers()))
);
// Print documentation comment
printf("--->Documentation:\n %s\n",var_export($method->getDocComment(),1));
if($statics=$method->getStaticVariables())//Print static variables if existant
 { printf("--->Static variables:%s\n",var_export($statics,1)); }
printf("--->Invokation results in: ");//Invoke the method
var_dump($method->invoke(NULL));
?> 