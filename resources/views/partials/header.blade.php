<header class="site-header">
    <h1>Deployment Checklist</h1>

    <form method="get" action="{{ route('check') }}" class="form form-check">
        <input type="url" name="url" placeholder="URL to check" required>
        <input type="submit" value="Check">
    </form>
</header>
