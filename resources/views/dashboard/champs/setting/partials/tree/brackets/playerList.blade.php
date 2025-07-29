<?php
$prefix = "singleElimination";
if ($championship->hasPreliminary() && $roundNumber == 1) {
    $prefix = "preliminary";
}
$className = $prefix . "_select";
$selectName = $prefix . "_fighters[]";

?>
<!-- r = round, m = match, f = fighter -->
@if (isset($show_tree))
    {{  $fighter->fullName }}
@else
    {{ $selected?->fullName ?? '-' }}
@endif
