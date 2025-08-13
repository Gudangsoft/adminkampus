<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO Test Page - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .meta-info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .success { background: #d4edda; border-left: 4px solid #28a745; }
        .warning { background: #fff3cd; border-left: 4px solid #ffc107; }
        .error { background: #f8d7da; border-left: 4px solid #dc3545; }
        .seo-score {
            text-align: center;
            margin: 20px 0;
        }
        .score {
            font-size: 48px;
            font-weight: bold;
            color: #28a745;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 15px;
            color: white;
            font-size: 12px;
        }
        .badge-success { background: #28a745; }
        .badge-warning { background: #ffc107; color: #000; }
        .badge-danger { background: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 SEO Performance Test</h1>
        <p class="text-muted">Real-time SEO analysis for {{ config('app.name') }}</p>

        <div class="seo-score">
            <div class="score" id="seoScore">-</div>
            <div>SEO Score</div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h3>📊 Meta Tags Analysis</h3>
                <div id="metaAnalysis">
                    <!-- Meta tags will be analyzed here -->
                </div>
            </div>

            <div class="col-md-6">
                <h3>🔗 Links & Structure</h3>
                <div id="linkAnalysis">
                    <!-- Link structure will be analyzed here -->
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h3>📱 Social Media Preview</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>Facebook Preview</h5>
                    <div id="facebookPreview" class="meta-info">
                        <!-- Facebook OG preview -->
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Twitter Preview</h5>
                    <div id="twitterPreview" class="meta-info">
                        <!-- Twitter Card preview -->
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h3>🏗️ Structured Data</h3>
            <div id="structuredData" class="meta-info">
                <!-- JSON-LD structured data -->
            </div>
        </div>

        <div class="mt-4">
            <h3>⚡ Performance Metrics</h3>
            <div id="performanceMetrics">
                <!-- Performance analysis -->
            </div>
        </div>

        <div class="mt-4">
            <h3>🔧 SEO Tools</h3>
            <div class="d-flex gap-2 flex-wrap">
                <a href="/sitemap.xml" target="_blank" class="badge badge-success">View Sitemap</a>
                <a href="/robots.txt" target="_blank" class="badge badge-success">View Robots.txt</a>
                <button onclick="analyzePage()" class="badge badge-warning">Re-analyze Page</button>
                <button onclick="clearCache()" class="badge badge-danger">Clear Cache</button>
            </div>
        </div>

        <div class="mt-4">
            <h3>📈 Quick Actions</h3>
            <div class="d-flex gap-2 flex-wrap">
                <a href="/" class="badge badge-success">Test Homepage</a>
                <a href="/news" class="badge badge-success">Test News Page</a>
                <a href="/gallery" class="badge badge-success">Test Gallery</a>
                <a href="/search?q=test" class="badge badge-success">Test Search</a>
            </div>
        </div>
    </div>

    <script>
        // Auto-analyze page on load
        window.addEventListener('load', function() {
            analyzePage();
        });

        function analyzePage() {
            let score = 0;
            let maxScore = 100;
            
            // Analyze meta tags
            const metaAnalysis = analyzeMetaTags();
            score += metaAnalysis.score;
            
            // Analyze links
            const linkAnalysis = analyzeLinks();
            score += linkAnalysis.score;
            
            // Analyze structured data
            const structuredAnalysis = analyzeStructuredData();
            score += structuredAnalysis.score;
            
            // Update score
            const finalScore = Math.round((score / maxScore) * 100);
            document.getElementById('seoScore').textContent = finalScore;
            document.getElementById('seoScore').style.color = 
                finalScore >= 80 ? '#28a745' : 
                finalScore >= 60 ? '#ffc107' : '#dc3545';
        }

        function analyzeMetaTags() {
            const analysis = document.getElementById('metaAnalysis');
            let html = '';
            let score = 0;

            // Check title tag
            const title = document.querySelector('title');
            if (title && title.textContent.length > 0) {
                if (title.textContent.length >= 30 && title.textContent.length <= 60) {
                    html += '<div class="meta-info success">✅ Title length optimal (' + title.textContent.length + ' chars)</div>';
                    score += 10;
                } else {
                    html += '<div class="meta-info warning">⚠️ Title length should be 30-60 chars (current: ' + title.textContent.length + ')</div>';
                    score += 5;
                }
            } else {
                html += '<div class="meta-info error">❌ Missing title tag</div>';
            }

            // Check meta description
            const description = document.querySelector('meta[name="description"]');
            if (description && description.content.length > 0) {
                if (description.content.length >= 120 && description.content.length <= 160) {
                    html += '<div class="meta-info success">✅ Meta description length optimal (' + description.content.length + ' chars)</div>';
                    score += 10;
                } else {
                    html += '<div class="meta-info warning">⚠️ Meta description should be 120-160 chars (current: ' + description.content.length + ')</div>';
                    score += 5;
                }
            } else {
                html += '<div class="meta-info error">❌ Missing meta description</div>';
            }

            // Check Open Graph tags
            const ogTitle = document.querySelector('meta[property="og:title"]');
            const ogDescription = document.querySelector('meta[property="og:description"]');
            const ogImage = document.querySelector('meta[property="og:image"]');
            
            if (ogTitle && ogDescription && ogImage) {
                html += '<div class="meta-info success">✅ Open Graph tags complete</div>';
                score += 10;
            } else {
                html += '<div class="meta-info warning">⚠️ Incomplete Open Graph tags</div>';
                score += 5;
            }

            analysis.innerHTML = html;
            return { score: score };
        }

        function analyzeLinks() {
            const analysis = document.getElementById('linkAnalysis');
            let html = '';
            let score = 0;

            // Count internal vs external links
            const links = document.querySelectorAll('a[href]');
            const internalLinks = Array.from(links).filter(link => 
                link.href.startsWith(window.location.origin) || link.href.startsWith('/')
            );
            const externalLinks = Array.from(links).filter(link => 
                !link.href.startsWith(window.location.origin) && !link.href.startsWith('/')
            );

            html += '<div class="meta-info">📊 Internal links: ' + internalLinks.length + '</div>';
            html += '<div class="meta-info">🔗 External links: ' + externalLinks.length + '</div>';
            
            if (internalLinks.length > 0) {
                html += '<div class="meta-info success">✅ Has internal linking</div>';
                score += 10;
            }

            // Check for heading structure
            const h1s = document.querySelectorAll('h1');
            if (h1s.length === 1) {
                html += '<div class="meta-info success">✅ Single H1 tag found</div>';
                score += 10;
            } else if (h1s.length === 0) {
                html += '<div class="meta-info error">❌ No H1 tag found</div>';
            } else {
                html += '<div class="meta-info warning">⚠️ Multiple H1 tags found (' + h1s.length + ')</div>';
                score += 5;
            }

            analysis.innerHTML = html;
            return { score: score };
        }

        function analyzeStructuredData() {
            const analysis = document.getElementById('structuredData');
            let html = '';
            let score = 0;

            // Check for JSON-LD structured data
            const jsonLd = document.querySelectorAll('script[type="application/ld+json"]');
            if (jsonLd.length > 0) {
                html += '<div class="meta-info success">✅ ' + jsonLd.length + ' JSON-LD structured data found</div>';
                score += 10;
                
                // Display structured data
                jsonLd.forEach((script, index) => {
                    try {
                        const data = JSON.parse(script.textContent);
                        html += '<details class="mt-2"><summary>Structured Data ' + (index + 1) + ' (' + (data['@type'] || 'Unknown') + ')</summary>';
                        html += '<pre style="background:#f8f9fa;padding:10px;border-radius:5px;font-size:12px;overflow:auto;">' + JSON.stringify(data, null, 2) + '</pre>';
                        html += '</details>';
                    } catch (e) {
                        html += '<div class="meta-info error">❌ Invalid JSON-LD syntax in script ' + (index + 1) + '</div>';
                    }
                });
            } else {
                html += '<div class="meta-info warning">⚠️ No structured data found</div>';
            }

            analysis.innerHTML = html;
            return { score: score };
        }

        function clearCache() {
            if (confirm('Clear Laravel cache? This will refresh all cached data.')) {
                fetch('/admin/cache/clear', { method: 'POST' })
                    .then(() => {
                        alert('Cache cleared successfully!');
                        location.reload();
                    })
                    .catch(() => {
                        alert('Failed to clear cache. Please run: php artisan cache:clear');
                    });
            }
        }
    </script>
</body>
</html>
