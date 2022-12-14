<?php

declare(strict_types=1);

/**
 * @var string $error_type
 * @var string $error_file
 * @var string $error_line
 * @var string $error_level
 * @var string $error_desc
 * @var string $error_trace_smg
 * @var string $source
 * @var array $error_array
 *
 */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
        echo $error_array['class']; ?> | Error Control Software</title>
    <style>

        body {
            font-family: Consolas, Helvetica, sans-serif;
            margin: 0;
            box-sizing: border-box;
            height: 100%;
            background-color: #696767;
            font-size: 1rem;
            color: rgba(128, 255, 128, 0.8);
            text-shadow: 0 0 1ex rgba(51, 255, 51, 1),
            0 0 2px rgba(255, 255, 255, 0.8);
        }

        .terminal {
            padding: 2rem 4rem;
        }

        .output {
            color: rgba(128, 255, 128, 0.8);
            text-shadow: 0 0 1px rgba(51, 255, 51, 0.4),
            0 0 2px rgba(255, 255, 255, 0.8);
        }

        .backlog {
            color: rgba(128, 168, 255, 0.8);
            text-shadow: 0 0 1px rgba(51, 68, 255, 0.2),
            0 0 2px rgba(255, 255, 255, 0.5);
        }

        .output::before {
            content: "> ";
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        a::before {
            content: "[";
        }

        a::after {
            content: "]";
        }

        .error_code {
            color: white;
        }
    </style>
</head>

<body>
<div class="noise"></div>
<div class="overlay"></div>
<div class="terminal">
    <h1><span class="error_code"><?php
            echo $error_array['class']; ?></span></h1>
    <p class="output"><b>File:</b> <?php
        echo $error_array['file'] ?></p>
    <p class="output"><b>Line:</b> <?php
        echo $error_array['line']; ?> <b>Level:</b> <?php
        echo $error_array['type']; ?></p>
    <p class="output"><b>Description:</b> <?php
        echo $error_array['description']; ?></p>
    <p class="output"><b>BackTrace Log:</b></p>
    <p class="backlog">
        <?php
        echo $error_array['trace_msg']; ?>
    </p>
    <p class="output">Please try to <a href="#" id="return">Go Back</a>.</p>
</div>
<!-- Return Home Script -->
<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function () {

        function refresh() {
            document.location.href = "/";
        }

        document.getElementById("return").addEventListener("click", function () {
            refresh();
        });

    });

</script>
</body>

</html>