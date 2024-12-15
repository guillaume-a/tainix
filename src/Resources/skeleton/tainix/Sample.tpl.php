<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

<?php echo $use_statements; ?>

#[AsSample(code: '<?php echo $challenge_code; ?>')]
class <?php echo $class_name; ?> implements SampleInterface
{
public function inputs(): InputInterface {
return new <?php echo $input_class; ?>(
<?php foreach ($inputs as $key => $value) { ?>
    <?php if (\is_array($value)) { ?>
        <?php echo \sprintf('%s: %s,', $key, var_export($value, true)); ?>
    <?php } else { ?>
        <?php echo \sprintf('%s: \'%s\',', $key, $value); ?>
    <?php } ?>
<?php } ?>
);
}

public function expected(): string {
return '<?php echo $expected; ?>';
}
}
