<?php $this->render('app/views/layout/header', $params); ?>

<div id="about-page-wrapper">
	<div class="row">
	    <div class="col-md-12">
	        <h3 class="display-3">
	            eMag's Hero
	        </h3>
	    </div>
	</div>
	<div class="row">
	    <div class="col-md-5">
	        <h4>
	            The Story
	        </h4>
	        <p>
	            Once upon a time there was a great hero, called <mark>Orderus</mark>, with some strengths and weaknesses, as all heroes have.
	        </p>
	        <p>
	            After battling all kinds of monsters for more than a hundred years, <mark>Orderus</mark> now has the following stats:
	        </p>
	        <ul>
	            <li>Health: 70 - 100</li>
	            <li>Strength: 70 - 80</li>
	            <li>Defence: 45 – 55</li>
	            <li>Speed: 40 – 50</li>
	            <li>Luck: 10% - 30% (0% means no luck, 100% lucky all the time)</li>
	        </ul>
	        <p>
	            Also, he possesses 2 skills:
	        </p>
	        <ul>
	            <li>Rapid strike: Strike twice while it’s his turn to attack; there’s a 10% chance he’ll use this skill every time he attacks</li>
	            <li>Magic shield: Takes only half of the usual damage when an enemy attacks; there’s a 20% change he’ll use this skill every time he defends</li>
	        </ul>
	    </div>
	    <div class="col-md-7">
	        <h4>
	            Gameplay
	        </h4>
	        <p>
	            As <mark>Orderus</mark> walks the ever-green forests of Emagia, he encounters some wild beasts, with the following properties:
	        </p>
	        <ul>
	            <li>Health: 60 - 90</li>
	            <li>Strength: 60 - 90</li>
	            <li>Defence: 40 – 60</li>
	            <li>Speed: 40 – 60</li>
	            <li>Luck: 25% - 40%</li>
	        </ul>
	        <p>
	            Here we simulate a battle between <mark>Orderus</mark> and a wild beast, using a web browser. On every battle, <mark>Orderus</mark> and the beast must be initialized with random properties, within their ranges.
	        </p>
	        <p>
	            The first attack is done by the player with the higher speed. If both players have the same speed, than the attack is carried on by the player with the highest luck. After an attack, the players switch roles: the attacker now defends and the defender now attacks.
	        </p>
	        <p>
	            The damage done by the attacker is calculated with the following formula:<br />
	            <code>Damage = Attacker strength – Defender defence</code>
	        </p>
	        <p>
	            The damage is subtracted from the defender’s health. An attacker can miss their hit and do no damage if the defender gets lucky that turn.
	        </p>
	        <p>
	            <mark>Orderus’</mark> skills occur randomly, based on their chances, so take them into account on each turn.
	        </p>
	    </div>
	</div>
	<hr>
	<div class="row">
	    <div class="col-md-10">
	        <h4>
	            Game over
	        </h4>
	        <p>
	            The game ends when one of the players remain without health or the number of turns reaches 20.
	        </p>
	        <p>
	            The application must output the results each turn: what happened, which skills were used (if any), the damage done, defender’s health left.
	        </p>
	        <p>
	            If we have a winner before the maximum number of rounds is reached, he must be declared.
	        </p>
	    </div>
	</div>
</div>

<?php $this->render('app/views/layout/footer', $params['config']); ?>