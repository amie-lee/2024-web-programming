const easyMaps = [
    [['empty','mountain90','empty','empty','oasis'],
        ['empty','empty','empty','bridge','oasis'],
        ['bridge','empty','mountain180','empty','empty'],
        ['empty','empty','empty','oasis','empty'],
        ['empty','empty','mountain270','empty','empty']],

    [['oasis','empty','bridge90','empty','empty'],
        ['empty','mountain180','empty','empty','mountain180'], 
        ['bridge','oasis','mountain270','empty','empty'], 
        ['empty','empty','empty','oasis','empty'], 
        ['empty','empty','empty','empty','empty']],

    [['empty','empty','bridge90','empty','empty'], 
        ['empty','empty','empty','empty','bridge'], 
        ['empty','mountain180','bridge','empty','empty'], 
        ['empty','oasis','empty','empty','empty'], 
        ['empty','bridge90','empty','empty','mountain180']],

    [['empty','empty','empty','bridge90','empty'], 
        ['empty','empty','empty','empty','empty'], 
        ['bridge','empty','mountain90','empty','mountain90'], 
        ['empty','empty','empty','empty','empty'], 
        ['empty','empty','oasis','mountain270','empty']],

    [['empty','empty','bridge90','empty','empty'], 
        ['empty','mountain','empty','empty','empty'], 
        ['bridge','empty','empty','mountain270','empty'], 
        ['empty','empty','bridge','oasis','empty'], 
        ['empty','mountain180','empty','empty','empty']]
]

const hardMaps = [
    [['empty','mountain90','oasis','oasis','empty','bridge90','empty'], 
        ['bridge','empty','empty','empty','empty','empty','empty'], 
        ['empty','empty','bridge','empty','empty','empty','empty'], 
        ['empty','empty','empty','mountain270','empty','empty','empty'], 
        ['mountain270','empty','mountain90','empty','bridge90','empty','oasis'],
        ['empty','empty','empty','empty','empty','empty','empty'],
        ['empty','empty','empty','bridge90','empty','empty','empty']],

    [['empty','empty','oasis','empty','empty','empty','empty'], 
        ['bridge','empty','bridge90','empty','empty','mountain180','empty'], 
        ['empty','empty','bridge90','empty','empty','empty','bridge'], 
        ['mountain','empty','empty','empty','empty','empty','empty'], 
        ['empty','oasis','empty','mountain90','empty','empty','empty'],
        ['empty','mountain','empty','empty','empty','empty','empty'],
        ['empty','empty','oasis','empty','empty','empty','empty']],

    [['empty','empty','bridge90','empty','empty','empty','empty'], 
        ['empty','empty','empty','empty','empty','empty','bridge'], 
        ['oasis','empty','mountain270','empty','empty','empty','empty'], 
        ['empty','empty','empty','empty','empty','empty','empty'], 
        ['empty','oasis','mountain270','empty','bridge90','empty','empty'],
        ['bridge','empty','empty','empty','empty','mountain90','empty'],
        ['empty','empty','oasis','mountain270','empty','empty','empty']],

    [['empty','empty','empty','empty','empty','empty','empty'], 
        ['empty','empty','empty','bridge','empty','mountain180','empty'], 
        ['empty','empty','mountain270','empty','empty','empty','empty'], 
        ['empty','bridge90','empty','oasis','empty','bridge90','empty'], 
        ['empty','empty','mountain180','empty','mountain90','empty','empty'],
        ['bridge','empty','empty','empty','empty','mountain270','empty'],
        ['empty','empty','empty','empty','empty','empty','empty']],

    [['empty','empty','empty','empty','empty','empty','empty'], 
        ['empty','empty','empty','empty','empty','mountain','empty'], 
        ['empty','bridge90','bridge90','empty','mountain90','empty','empty'], 
        ['empty','empty','empty','empty','empty','empty','empty'], 
        ['empty','empty','mountain','empty','oasis','empty','empty'],
        ['empty','mountain180','empty','bridge','empty','empty','empty'],
        ['empty','empty','empty','empty','empty','empty','empty']]
]

export default {
    easyMaps,
    hardMaps
}