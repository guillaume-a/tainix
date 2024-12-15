<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

<?php echo $use_statements; ?>

final readonly class <?php echo $class_name; ?> implements InputInterface
{
public function __construct(
<?php foreach ($keys as $key) { ?>
<?php echo 'public mixed $'.$key.','; ?>
<?php } ?>
) {
}
}
