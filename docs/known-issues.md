Known issues
============

Number handling
---------------

When using `case-converter` you cannot use a number as separator. In practice 
this means that a number is not considered as a word: 

![Phing targets](./number-problem.png "Phing targets")

As shown in the previous example, there is no way to go back to the original 
input string (i.e. `hello-8-world`), in _kebab case_ this sting is written as 
`hello8-world`.  
