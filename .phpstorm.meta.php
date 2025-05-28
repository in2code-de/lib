<?php

namespace PHPSTORM_META {

    override(\CoStack\Lib\factory(), map(["" => "$0"]));
    override(\CoStack\Lib\Utility\ObjectUtility::factory(), map(["" => "$0"]));

    registerArgumentsSet(
        'cos_lib_filter_flags',
        \CoStack\Lib\FILTER_INVERT |
        \CoStack\Lib\FILTER_MATCH_LOOSE,
    );
    expectedArguments(\CoStack\Lib\filter(), 1, argumentsSet('cos_lib_filter_flags'));
    expectedArguments(\CoStack\Lib\Utility\FilterUtility::filter(), 1, argumentsSet('cos_lib_filter_flags'));
}
