/**
 * [similar_text - Levenshtein's Algorithm]
 * @param  {[String]} str1 [test string]
 * @param  {[String]} str2 [correct string]
 * @return {[int]} percent [similarity percentage]
 */
function similar_text(str1, str2) {
    var m = str1.length,
        n = str2.length,
        d = [],
        i, j;
 
    if (!m) return n;
    if (!n) return m;
 
    for (i = 0; i <= m; i++) d[i] = [i];
    for (j = 0; j <= n; j++) d[0][j] = j;
 
    for (j = 1; j <= n; j++) {
        for (i = 1; i <= m; i++) {
            if (str1[i-1] == str2[j-1]) d[i][j] = d[i - 1][j - 1];
            else d[i][j] = Math.min(d[i-1][j]+1, d[i][j-1]+1, d[i-1][j-1]+1);
        }
    }
    percent = ((str2.length-d[m][n])/str2.length)*100;
    return percent;
}