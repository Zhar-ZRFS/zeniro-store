#!/usr/bin/env bash
# Pre-deployment verification script untuk Vercel

echo "🔍 ZENIRO STORE - PRE-DEPLOYMENT VERIFICATION"
echo "=============================================="
echo ""

# 1. Check .gitignore
echo "[1/8] Checking .gitignore..."
if grep -q "vendor" .gitignore && grep -q "node_modules" .gitignore; then
    echo "✅ .gitignore looks good"
else
    echo "❌ WARNING: vendor or node_modules not in .gitignore"
fi

# 2. Check vercel.json exists
echo "[2/8] Checking vercel.json..."
if [ -f "vercel.json" ]; then
    if grep -q "no-dev" vercel.json && grep -q "optimize-autoloader" vercel.json; then
        echo "✅ vercel.json configured correctly"
    else
        echo "❌ vercel.json missing required build flags"
    fi
else
    echo "❌ vercel.json not found"
fi

# 3. Check .vercelignore exists
echo "[3/8] Checking .vercelignore..."
if [ -f ".vercelignore" ]; then
    if grep -q "vendor" .vercelignore && grep -q "node_modules" .vercelignore; then
        echo "✅ .vercelignore configured correctly"
    else
        echo "❌ .vercelignore missing critical entries"
    fi
else
    echo "❌ .vercelignore not found"
fi

# 4. Check composer.json exists
echo "[4/8] Checking composer.json..."
if [ -f "composer.json" ]; then
    echo "✅ composer.json exists"
else
    echo "❌ composer.json not found"
fi

# 5. Check package.json exists
echo "[5/8] Checking package.json..."
if [ -f "package.json" ]; then
    echo "✅ package.json exists"
else
    echo "❌ package.json not found"
fi

# 6. Check local vendor/node_modules not committed
echo "[6/8] Checking for uncommitted vendor/node_modules..."
if git ls-files --error-unmatch vendor &> /dev/null; then
    echo "❌ WARNING: vendor is tracked in git (should be in .gitignore)"
else
    echo "✅ vendor not in git"
fi

if git ls-files --error-unmatch node_modules &> /dev/null; then
    echo "❌ WARNING: node_modules is tracked in git (should be in .gitignore)"
else
    echo "✅ node_modules not in git"
fi

# 7. Check key files exist
echo "[7/8] Checking essential files..."
files=("app/Models/User.php" "routes/web.php" "public/index.php" ".env.example")
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file exists"
    else
        echo "❌ $file missing"
    fi
done

# 8. Calculate project size
echo "[8/8] Calculating project size (excluding git)..."
if [ -d ".git" ]; then
    size=$(du -sh --exclude=.git --exclude=vendor --exclude=node_modules . 2>/dev/null | cut -f1)
else
    size=$(du -sh . 2>/dev/null | cut -f1)
fi
echo "Project size (without vendor/node_modules): $size"

echo ""
echo "=============================================="
echo "✅ PRE-DEPLOYMENT VERIFICATION COMPLETE"
echo ""
echo "Next steps:"
echo "1. Run: ./cleanup-for-vercel.sh"
echo "2. Run: git add . && git commit -m 'optimize for vercel'"
echo "3. Run: git push"
echo "4. Deploy from Vercel Dashboard"
echo ""
