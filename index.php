<?php

require_once 'src/DependencyInjection/DiContainer.php';
$diContainer = new \DependencyInjection\DiContainer();

$solver = $diContainer->get(\SimplexSolver\SimplexSolver::class);

$lp = require 'lp.php';
$solver->run($lp);
