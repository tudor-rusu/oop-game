OOP Game
======================================

[![Conventional Commits][conventional-commits-image]][conventional-commits-url]

The scope of the project is about to highlight Oriented Object Programming concepts and S.O.L.I.D principles.

## About the project
#### Project stack  
* PHP 7.2
* nginx alpine
* Composer
* Phpunit
* Bootstrap 4

#### Design patterns
* Singleton
* Front Controller
* MVC
* Factory Method
* Fluent Interface
* Dependency Injection
* Strategy
* Delegation

#### Story and Project requirements  
**The story**  
Once upon a time there was a great hero, called **Orderus**, with some strengths and weaknesses, as all heroes have.
After battling all kinds of monsters for more than a hundred years, **Orderus** now has the following stats:
* Health: 70 - 100
* Strength: 70 - 80
* Defence: 45 – 55
* Speed: 40 – 50
* Luck: 10% - 30% (0% means no luck, 100% lucky all the time)  

Also, he possesses 2 skills:
* Rapid strike: Strike twice while it’s his turn to attack; there’s a 10% chance he’ll use this skill every time he attacks
* Magic shield: Takes only half of the usual damage when an enemy attacks; there’s a 20% change he’ll use this skill every time he defends.

**Gameplay**
As **Orderus** walks the ever-green forests of **Emagia**, he encounters some wild beasts, with the following properties:
* Health: 60 - 90
* Strength: 60 - 90
* Defence: 40 – 60
* Speed: 40 – 60
* Luck: 25% - 40%  

The project simulate a battle between **Orderus** and a wild beast, either at command line or using a web browser. On every battle, **Orderus** and the beast must be initialized with random properties, within their ranges.   
 
 The first attack is done by the player with the higher speed. If both players have the same speed, then the attack is carried on by the player with the highest luck. After an attack, the players switch roles: the attacker now defends, and the defender now attacks.  
   
The damage done by the attacker is calculated with the following formula:
```
Damage = Attacker strength – Defender defence
```
The damage is subtracted from the defender’s health. An attacker can miss their hit and do no damage if the defender gets lucky that turn.  

Orderus’ skills occur randomly, based on their chances, so take them into account on each turn.  

**Game over**  

The game ends when one of the players remain without health, or the number of turns reaches 20.  

The application must output the results each turn: what happened, which skills were used (if any), the damage done, defender’s health left.  

If we have a winner before the maximum number of rounds is reached, he must be declared.

## Install and run on local machine

### Prerequisites
Before start install, user will need:
* One [Bionic Beaver][1], and a non-root user with `sudo` privileges.
* [Composer][2]
* [Docker][3]
* [Docker Compose][4]

### Install local
* Clone repository
```shell script
git clone https://github.com/tudor-rusu/oop-game.git ${PROJECT_ROOT}
```
* Copy and adjust environmental settings in the root of the project, assumed `${PROJECT_ROOT}`:
```shell script
cd ${PROJECT_ROOT}
cp .env.dist .env
```

[conventional-commits-image]: https://img.shields.io/badge/Conventional%20Commits-1.0.0-yellow.svg
[conventional-commits-url]: https://conventionalcommits.org/
[1]: http://releases.ubuntu.com/18.04.4/
[2]: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-18-04
[3]: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04
[4]: https://www.digitalocean.com/community/tutorials/how-to-install-docker-compose-on-ubuntu-18-04
