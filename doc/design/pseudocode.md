Destroysession

IF session not exist THEN
    Create yatzy object to session
ELSE
    Continue with game

IF POST next toss THEN
    Toss selected dice
    AND add one two "counter" variable
ELSE
    Toss all dices (only happens first time)

IF counter is 3 THEN
    CALL function to add score
    AND add 1 to round
    AND reset counter to 0

IF round is greater THAN 7 THEN
    START the other functions and contiune with the game

IF round is 15 THEN
    IF Player choose to save score
        CALL function to save score to database
    ELSE
        End game and show result
ELSE
    Continue playing the game with the different functions
