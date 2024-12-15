<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

<?php echo $use_statements; ?>

#[AsSample(code: '<?php echo $challenge_code; ?>')]
class <?php echo $class_name; ?> implements SampleInterface
{
public function inputs(): InputInterface {
return new <?php echo $input_class; ?>(
<?php foreach ($inputs as $key => $value) { ?>
<?php echo \sprintf('%s: \'%s\',', $key, $value); ?>
<?php } ?>
);
}

public function expected(): string {
return '<?php echo $expected; ?>';
}
}
