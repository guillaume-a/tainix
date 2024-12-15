<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

<?php echo $use_statements; ?>

/**
* Link to challenge statement:
* https://tainix.fr/engines/code/<?php echo $challenge_code; ?>
*
*/
#[AsChallenge(code: '<?php echo $challenge_code; ?>')]
class <?php echo $class_name; ?> implements ChallengeInterface
{
/**
* @param <?php echo $input_class_name; ?> $input
*/
public function solve(InputInterface $input): string
{
throw new \Exception('Challenge not implemented.');
}
}
