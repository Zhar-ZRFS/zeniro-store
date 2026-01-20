#!/bin/bash
# Cleanup script untuk optimasi deployment ke Vercel

echo "🧹 Starting Vercel Deployment Optimization..."

# 1. Remove vendor dan node_modules (akan diinstall di Vercel)
if [ -d "vendor" ]; then
    echo "❌ Removing vendor folder..."
    rm -rf vendor
fi

if [ -d "node_modules" ]; then
    echo "❌ Removing node_modules folder..."
    rm -rf node_modules
fi

# 2. Clear cache
if [ -d "bootstrap/cache" ]; then
    echo "🧹 Cleaning bootstrap cache..."
    rm -rf bootstrap/cache/*
    touch bootstrap/cache/.gitkeep
fi

# 3. Clear logs
if [ -d "storage/logs" ]; then
    echo "🧹 Cleaning logs..."
    rm -f storage/logs/*.log
fi

# 4. Optimize image sizes (jika ada ImageOptim atau similar)
echo "📸 Consider optimizing images in public/img..."
echo "   Gunakan: https://www.imageoptim.com/ atau https://tinypng.com/"

# 5. Check size
echo ""
echo "📊 Calculating final size..."
du -sh . 2>/dev/null | awk '{print "Total size: " $1}'

echo ""
echo "✅ Optimization complete!"
echo "📤 Ready to deploy to Vercel with: git push origin main"
echo ""
echo "⚠️  REMINDER: Make sure .gitignore includes vendor and node_modules"
