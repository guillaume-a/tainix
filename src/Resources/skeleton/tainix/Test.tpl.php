<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

<?php echo $use_statements; ?>

class <?php echo $class_name; ?> extends AbstractTainixTestCase
{
public function testItSolvesWithSampleData()
{
$this->assertSolveWithSampleData();
}

// Auto generated functions

public function getChallengeClassName(): string
{
return <?php echo $challenge_class; ?>::class;
}

public function getSampleClassName(): string
{
return <?php echo $sample_class; ?>::class;
}

public function getChallengeCode(): string
{
return '<?php echo $challenge_code; ?>';
}
}
