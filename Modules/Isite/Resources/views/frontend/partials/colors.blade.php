@php
    $primary = setting("isite::brandPrimary");
    $primaryContrast = setting("isite::primaryContrast");
    $secondary = setting("isite::brandSecondary");
    $secondaryContrast = setting("isite::secondaryContrast");
    $success = setting("isite::brandPositive");
    $info = setting("isite::brandInfo");
    $warning = setting("isite::brandWarning");
    $danger = setting("isite::brandNegative");
    $dark = setting("isite::brandDark");
@endphp
<style>
    :root {
        --primary: {{$primary}};
        --primary-contrast: {{$primaryContrast}};
        --secondary: {{$secondary}};
        --secondary-contrast: {{$secondaryContrast}};
        --success: {{$success}};
        --info: {{$info}};
        --warning: {{$warning}};
        --danger: {{$danger}};
        --dark: {{$dark}};
    }
</style>