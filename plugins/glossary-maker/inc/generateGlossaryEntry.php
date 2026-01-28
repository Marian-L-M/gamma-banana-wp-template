<?php

function generateGlossaryEntry() {
  // Switch to wp options or meta to make dynamic
  $species = ["human", "chitinous", "avian", "dragon", "aquatian", "chicken"];
  $first_names = ["Alain", "Art", "Anne", "Archiebald", "Belle", "Bailey", "Beau", "Benji", "Bennjamin", "Blue", "Bonnie","Bruno", "Brutus", "Brunhilde", "Charlotte", "Casper", "Charles", "Chester", "Clarissa", "Daisy", "Duke", "Dustan", "Ellen", "Elisabeth", "Emma", "Felice", "Gudrun", "George", "Gus", "Hildegaard", "Hannah", "Haidemary", "Hazel", "Henry", "Holly", "Jackery", "Jasmine", "Katelyn", "Lily", "Lothar", "Louis", "Lucy", "Lukas", "Madison", "Margery", "Marland", "Maximilian", "Marianne", "Molly", "Murphy", "Nathalie", "Oliver", "Olga", "Otis", "Pennyworth", "Phoebe", "Randall", "Riley", "Robert", "Roscoe", "Roselyn", "Roxanne", "Ruby", "Rudolf", "Samantha", "Samwell","Sasha", "Simon","Sophia", "Stella","Tobias", "Walter", "Willow", "Winston"];
  $last_names = ["Medici", "Borgia", "Sforza", "Gonzaga", "d'Este", "Visconti", "Habsburg", "Valois", "Tudor", "Bourbon", "Fugger", "Della Rovere", "Farnese", "Orsini", "Colonna", "Malatesta", "Bentivoglio", "Montefeltro", "Piccolomini", "Strozzi"];
  $titles = ["Lord", "Lady", "Duke", "Duchess", "Baron", "Baroness", "Count", "Countess", "Marquis", "Marchioness", "Earl", "Viscount", "Knight", "Dame", "Sir", "Monsignor", "Cardinal", "Prince", "Princess", "Archduke"];
  $faction = ["Medici Bank", "Venetian Republic", "Florentine Guild", "Papal States", "Holy Roman Empire", "House of Habsburg", "Hanseatic League", "Knights Templar", "Dominican Order", "Franciscan Order", "Council of Ten", "Merchant's Guild", "Artificer's Guild", "Painter's Guild", "House of Valois", "Tudor Court", "Borgia Family", "Sforza Dynasty", "Republic of Genoa", "Kingdom of Naples"];
  $foods = ["Roasted Pheasant", "Venison Haunch", "Honeyed Mead", "Mulled Wine", "Manchet Bread", "Aged Cheese", "Salted Pork", "Spiced Lamb", "Roasted Swan", "Pickled Herring", "Meat Pie", "Candied Fruit", "Almond Tart", "Peacock", "Boar", "Mutton Stew", "Trencher Bread", "Hippocras", "Marchpane", "Quince Preserve"];
  $profession = ["Blacksmith", "Merchant", "Painter", "Sculptor", "Scribe", "Alchemist", "Apothecary", "Goldsmith", "Silk Weaver", "Cartographer", "Astrologer", "Minstrel", "Falconer", "Armorer", "Illuminator", "Banker", "Architect", "Herbalist", "Glassblower", "Lute Maker"];


  return [
    'species' => $species[array_rand($species, 1)],
    'birthyear' => rand(0, 10000),
    'score' => rand(1, 10000),
    'favfood' => $foods[array_rand($foods, 1)],
    'first_name' => $first_names[array_rand($first_names, 1)],
    'last_name' => $last_names[array_rand($last_names, 1)],
    'title_name' => $titles[array_rand($titles, 1)],
    'faction' => $faction[array_rand($faction, 1)],
    'profession' => $profession[array_rand($profession, 1)]
    ];
}